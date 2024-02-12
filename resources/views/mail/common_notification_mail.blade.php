<!DOCTYPE html>
<html>

<head>
    <title>Notification:- {{ $data['heading'] }}</title>
    <style>
        .title {
            text-align: center;
            margin-top: 20px;
            background: #b6fdcf;
        }

        .title h1 {
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #b6fdcf;
            color: #000;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        a {
            background: linear-gradient(to right, #4bfff0, #1cd6fb);
            color: rgb(0, 0, 0);
            padding: 10px 16px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            text-decoration: none;
            border-radius: 5px;
            opacity: 0.8;
        }

        a:hover {
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="title" <h1>{{ $data['heading'] }}</h1>
    </div>

    <p>{{ $data['greetings'] }},</p>
    <p>{{ $data['message'] }}</p>
    <table>
        <tbody>
            <tr>
                <th>Client Name</th>
                <td>{{ $data['client_name'] }}</td>
            </tr>
            <tr>
                <th>Client ID</th>
                <td>{{ $data['client_no'] }}</td>
            </tr>
            <tr>
                <th>Client MQ No</th>
                <td>{{ $data['mq_no'] }}</td>
            </tr>
            <tr>
                <th>FR No</th>
                <td>{{ $data['fr_no'] }}</td>
            </tr>
        </tbody>
    </table>
    <br />
    <a type="button" class="btn btn-primary" href="{{ $data['url'] }}">{{ $data['button_text'] }}</a>
    <p>{{ $data['auto_mail_alert'] }}</p>
    <p>Regards</p>
    <p>{{ $data['regards'] }}</p>

</body>

</html>
