# Accessing booking data
This example details some of the basic properties on a booking.

The example lists links to perform some common tasks you might want to do such as creating a provisional booking, cancelling it and adding a customer.

```php

try {
    if ($id = filter_input(INPUT_GET, 'id')) {

        $booking = new \tabs\apiclient\Booking($id);
        $booking->get();
        
        ?>
            <h2>Booking: <?php echo $booking->getId(); ?> <a href="<?php echo $booking->getTabs2Url(); ?>" target="_blank">view</a></h2>
            <p>From: <?php echo $booking->getFromdate()->format('Y-m-d'); ?></p>
            <p>To: <?php echo $booking->getTodate()->format('Y-m-d'); ?></p>
            <p>Booked: <?php echo $booking->getBookeddatetime()->format('Y-m-d H:i:s'); ?></p>
            <p>Property: <?php echo $booking->getProperty()->getName(); ?></p>
            <p>Status: <?php echo $booking->getStatus(); ?>
        <?php
            if (!$booking->isProvisional() && !$booking->isCancelled()) {
                ?>
            <p><a href="provisional-booking.php?id=<?php echo $booking->getId(); ?>">Create provisional booking</a></p>
                <?php
            }
        
            if (!$booking->isConfirmed() && $booking->isProvisional()) {
                ?>
            <p>Deposit due: <?php echo $booking->getProvisionalbooking()->getDepositduedate()->format('d F Y'); ?></p>
            <p><a href="confirm-booking.php?id=<?php echo $booking->getId(); ?>">Confirm booking</a></p>
                <?php
            }
        
            if (!$booking->isCancelled()) {
                ?>
            <p><a href="cancel-booking.php?id=<?php echo $booking->getId(); ?>">Cancel booking</a></p>
                <?php
            }
        
            if ($booking->getCustomers()->count() == 0) {
                ?>
            <p><a href="add-customer.php?id=<?php echo $booking->getId(); ?>">Add booking customer</a></p>
                <?php
            } else {
                ?>
            <p>Customer: <?php echo $booking->getCustomers()->first()->getCustomer()->getFullname(); ?>
                <?php
            }
        
            if ($booking->getGuests()->count() == 0) {
                ?>
            <p><a href="add-guests.php?id=<?php echo $booking->getId(); ?>">Add booking guest</a></p>
                <?php
            } else {                
                $collection = $booking->getGuests();
                include __DIR__ . '/../collection.php';
            }
            
            if ($booking->getProperty()->getMaximumpets() >= 2) {
                ?>
            <p><a href="adding-pets.php?id=<?php echo $booking->getId(); ?>">Add 2 pets to this booking</a></p>
                <?php
            }

            ?>
            <p>Total paid: £<?php echo $booking->getTotalPaid(); ?></p>
            <?php
            if ($booking->getTotalOutstanding() > 0) {
                ?>
            <p><a href="create-sagepayment.php?id=<?php echo $booking->getId(); ?>">Add Payment</a></p>
                <?php
            }
            
            echo '<h5>Price</h5>';
            echo '<p>Brochure: £' . $booking->getBrochurePrice();
            $extras = $booking->getExtras()->findBy(function($ele) {
                return !$ele->getConfiguration()->isIncluded();
            });
            if ($extras->count() > 0) {
                foreach ($extras as $extra) {
                    echo sprintf(
                        '<p>%s: %s x £%s <a href="remove-extra.php?id=%s&beid=%s">Remove</a></p>',
                        $extra->getExtra()->getDescription(),
                        $extra->getQuantity(),
                        $extra->getUnitprice(),
                        $booking->getId(),
                        $extra->getId()
                    );
                }
            }
            echo '<p>Total: £' . $booking->getTotalPrice();
            
            if ($booking->getSecuritydeposits()->count() > 0) {
                echo sprintf(
                    '<p>Security deposit: £%s <a href="remove-sd.php?id=%s&bsid=%s">Remove</a> <a href="toggle-waiver.php?id=%s">Toggle Waiver</a></p>',
                    $booking->getSecuritydeposits()->first()->getAmount(),
                    $booking->getId(),
                    $booking->getSecuritydeposits()->first()->getId(),
                    $booking->getId()
                );
            } else if ($booking->getProperty()->getSecuritydeposits()->count() > 0) {
                echo sprintf(
                    '<p><a href="toggle-waiver.php?id=%s">Toggle Waiver</a></p>',
                    $booking->getId()
                );
            }
            
            // Get the branding extras and output list of available
            $extras = $booking->getBranding()->getExtras();
            if ($extras->count() > 0) {
                echo '<h5>Available extras</h5>';
                foreach ($extras as $extra) {
                    echo sprintf(
                        '<p>%s <a href="add-extra.php?id=%s&eid=%s">Add</a></p>',
                        $extra->getExtra()->getDescription(),
                        $booking->getId(),
                        $extra->getExtra()->getId()
                    );
                }
            }
    } else {

        $collection = tabs\apiclient\Collection::factory(
            'booking',
            new \tabs\apiclient\Booking
        );
        $collection->setLimit(filter_input(INPUT_GET, 'limit'))
            ->setPage(filter_input(INPUT_GET, 'page'))
            ->fetch();

        include __DIR__ . '/../collection.php';
    }

} catch(Exception $e) {
    echo $e->getMessage();
}

```

* [Creating a new booking](creating-a-booking.html)
* [Adding a customer](add-customer.html)
* [Adding a extra](add-extra.html)
* [Removing an extra](remove-extra.html)
* [Adding guests to a booking](add-guests.html)
* [Adding a sagepay payment](create-sagepaypayment.html)
* [Converting to a provisional booking](provisional-booking.html)
* [Removing a security deposit](remove-sd.html)
* [Toggling a security deposit waiver](toggle-waiver.html)
* [Performing a booking enquiry](booking-enquiry.html)
* [Cancelling a booking](cancel-booking.html)