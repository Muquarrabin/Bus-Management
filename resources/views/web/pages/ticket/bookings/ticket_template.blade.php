<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket</title>
</head>
<body>
<p><strong>Bus Ticket</strong></p>
<table style="border-collapse: collapse; width: 100%; height: 346px;" border="1">
    <tbody>
    <tr style="height: 53px;">
        <td style="width: 23.1534%; height: 53px;"><strong>Ticket No</strong></td>
        <td style="width: 76.8466%; height: 53px;">{{$booking->ticket_no}}</td>
    </tr>
    <tr style="height: 40px;">
        <td style="width: 23.1534%; height: 40px;"><strong>Customer Name</strong></td>
        <td style="width: 76.8466%; height: 40px;">{{$booking->customer->customer_name}}</td>
    </tr>
    <tr style="height: 39px;">
        <td style="width: 23.1534%; height: 39px;"><strong>Customer Mobile</strong></td>
        <td style="width: 76.8466%; height: 39px;">{{$booking->customer->customer_mobile}}</td>
    </tr>
    <tr style="height: 46px;">
        <td style="width: 23.1534%; height: 46px;"><strong>Customer Address</strong></td>
        <td style="width: 76.8466%; height: 46px;">{{$booking->customer->customer_address}}</td>
    </tr>
    <tr style="height: 46px;">
        <td style="width: 23.1534%; height: 46px;"><strong>From</strong></td>
        <td style="width: 76.8466%; height: 46px;">{{$booking->schedule->start_route}}</td>
    </tr>
    <tr style="height: 46px;">
        <td style="width: 23.1534%; height: 46px;"><strong>To</strong></td>
        <td style="width: 76.8466%; height: 46px;">{{$booking->schedule->end_route}}</td>
    </tr>
    <tr style="height: 40px;">
        <td style="width: 23.1534%; height: 40px;"><strong>Departure Date</strong></td>
        <td style="width: 76.8466%; height: 40px;">{{$booking->schedule->departure_date}}</td>
    </tr>
    <tr style="height: 50px;">
        <td style="width: 23.1534%; height: 50px;"><strong>Departure Time</strong></td>
        <td style="width: 76.8466%; height: 50px;">{{$booking->schedule->departure_time}}</td>
    </tr>
    <tr style="height: 38px;">
        <td style="width: 23.1534%; height: 38px;"><strong>Bus Number</strong></td>
        <td style="width: 76.8466%; height: 38px;">{{$booking->schedule->coach->bus_number}}</td>
    </tr>
    <tr style="height: 40px;">
        <td style="width: 23.1534%; height: 40px;"><strong>Seats</strong></td>
        <td style="width: 76.8466%; height: 40px;">{{$booking->seat_ids}}</td>
    </tr>
    </tbody>
</table>
<p><strong>***Save the ticket no or Save the ticket</strong></p>
</body>
</html>
