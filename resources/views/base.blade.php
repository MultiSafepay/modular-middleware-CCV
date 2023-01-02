<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MultiSafepay Payments</title>
    <script defer src="https://unpkg.com/alpinejs@3.2.2/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <meta name="theme-color" content="#004A71">
    <style>

        .bg-multisafepay {
            --tw-bg-opacity: 1;
            background-color: rgba(0, 74, 113, var(--tw-bg-opacity)) !important;
        }
        .text-multisafepay {
            --tw-text-opacity: 1;
            color: rgba(0, 74, 113, var(--tw-text-opacity));
        }
    </style>
</head>
<body class="bg-gray-50">
<header class="bg-multisafepay p-1 flex justify-center align-center items-center shadow sticky top-0">
    <div class="col-sm-2 flex mx-auto">
        <img class="img-fluid p-2" src="/images/CCV/msp-logo-white.svg"/>
    </div>
</header>
<main>
    @section('content')
    @show
</main>
<footer></footer>
</body>
</html>
