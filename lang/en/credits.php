<?php

return [
    // Titles of pages
    'title.index' => 'Credits List',
    'title.create' => 'Create Credit',
    'title.show' => 'Credit ":credit" Information',
    'title.maximum.amount.exceeded' => 'Maximum credits amount reached',

    // Buttons
    'button.make.payment' => 'Pay',
    'button.create.credit' => 'Create Credit',
    'button.store.credit' => 'Create',
    'button.make.global.payment' => 'Make Payment',

    // Table
    'table.borrower.name' => 'Borrower Name',
    'table.credit.amount' => 'Amount',
    'table.term' => 'Term / months',
    'table.installment' => 'Installment / month',
    'table.payment.date' => 'Payment Date',
    'table.payment.status' => 'Payment Status',
    'table.credit.status' => 'Credit Status',
    'table.credit.status.active' => 'Active',
    'table.credit.status.closed' => 'Closed/Paid',
    'table.no.credits' => 'No Records Found',

    // Forms
    'form.create.label.first.name' => 'First Name',
    'form.create.label.last.name' => 'Last Name',
    'form.create.label.amount' => 'Amount / BGN',
    'form.create.placeholder.amount' => 'for ex. 8500.49',
    'form.create.label.term' => 'Term / mounts',
    'form.create.label.credit' => 'Credit',
    'form.create.option.no.credits' => 'No Credits Found',

    // Pages Texts
    'page.create.personal.information' => 'Personal Information and Credit Request',
    'page.show.credit.borrower' => 'Credit Borrower',
    'page.show.credit.amount' => 'Credit Amount',
    'page.show.credit.term' => 'Credit Term',
    'page.show.credit.remaining' => 'Credit Remaining Amount',
    'page.show.credit.status' => 'Status',

    // mae = max amount exceeded
    'page.mae.total' => 'Total Amount in BGN of Active Credits',
    'page.mae.max.possible' => 'You can give the client not more than <strong>:amount</strong> bgn.',

    // General
    'general.month' => '{1} :value month|[2,*] :value months',

    // Notifications
    'notification.credit.created.successfully' => 'Credit has been successfully created!',
    'notification.credit.created.failed' => 'There was a problem creating the credit!',
    'notification.payment.successful' => 'Payment successful.',
    'notification.payment.failed' => 'Payment failed. Please try again.',
    'notification.payment.reminder' => 'The credit is fully paid with a remaining amount of :remaining has not been charged!',
    'notification.amount.subtracted' => 'The amount of <strong>:amount</strong> bgn has been subtracted from your next payment on :date!',
    'notification.previous.not.payed' => 'Previous installment is not paid.',
];
