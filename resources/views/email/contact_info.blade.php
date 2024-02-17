<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Information</title>
</head>
<body>
    <h2>Contact Information</h2>

    <p><strong>User ID:</strong> {{ $contacts->name }}</p>
    <p><strong>First Name:</strong> {{ $contacts->f_name }}</p>
    <p><strong>Last Name:</strong> {{ $contacts->l_name }}</p>
    <p><strong>Phone Number:</strong> {{ $contacts->phone_no }}</p>
    <p><strong>Assistant's Name:</strong> {{ $contacts->assistants_name }}</p>
    <p><strong>Assistant's Email:</strong> {{ $contacts->assistants_mail }}</p>
    <p><strong>Assistant's Phone:</strong> {{ $contacts->assistants_phone }}</p>
    <p><strong>Department Name:</strong> {{ $contacts->department_name }}</p>
    <p><strong>Date of Birth:</strong> {{ $contacts->dob }}</p>
    <p><strong>Social Media Profile:</strong> {{ $contacts->social_media_profile ?? 'Not provided' }}</p>
    <p><strong>Notes:</strong> {{ $contacts->notes ?? 'No notes available' }}</p>

    <p><strong>Billing Address:</strong></p>
    <p>{{ $contacts->billing_city }}, {{ $contacts->billing_state }}, {{ $contacts->billing_country }}, {{ $contacts->billing_zip }}</p>

    <p><strong>Shipping Address:</strong></p>
    <p>{{ $contacts->shipping_city }}, {{ $contacts->shipping_state }}, {{ $contacts->shipping_country }}, {{ $contacts->shipping_zip }}</p>

    <p>Thank you for using our service!</p>

</body>
</html>
