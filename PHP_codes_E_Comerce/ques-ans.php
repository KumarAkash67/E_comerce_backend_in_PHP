<?php
    $q1->que = "What is the status of my order?";
    $q1->ans = "Once you have placed your order, we will send you a confirmation email to track the status of your order.

    Once your order is shipped we will send you another email to confirm you the expected delivery date as well as the link to track your order (when the delivery method allows it).
    
    Additionally, you can track the status of your order from your \"order history\" section on your account page on the website.
    ";

    $q2->que = "What payment methods do you accept?";
    $q2->ans = "You can purchase on our website using a debit or credit card.

    We additionnaly offer support for Paypal, Amazon Pay, Apple Pay, and Google Pay.
    
    You can chose these payment methods at checkout.";

    $q3->que = "Which currency will I be charged in?";
    $q3->ans = "INR";

    $q4->que = "What if I'm not home?";
    $q4->ans = "If you're not home, a new delivery will be performed the next day or the delivery partner will reach out to schedule a new delivery date depending on the country and delivery method you choose.";

    $q5->que = "Do you accept returns?";
    $q5->ans = "We do accept returns in respect to the following conditions:

    - The item must have been sold on our online store
    - The item shouldn't have been used in any way
    - The return or exchange request is made within 28 days of delivery
    - The return is made within 14 days of the return or exchange request";

    $q6->que = "Are returns free?";
    $q6->ans = "YES";

    $q->question = array($q1, $q2, $q3, $q4, $q5, $q6);

    echo json_encode($q);
?>