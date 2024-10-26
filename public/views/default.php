<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Framework</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap");

        *,
        *:after,
        *:before {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            scrollbar-width: thin;
            scrollbar-color: var(--bs-gray-900) var(--bs-white);
        }
        *::-webkit-scrollbar {width: 12px}
        *::-webkit-scrollbar-track {background: var(--bs-white)}
        *::-webkit-scrollbar-thumb {background-color: var(--bs-gray-900);border: 3px solid var(--bs-white)}

        .selector-for-some-widget {box-sizing: content-box}

        body, html {
            position: relative;
            width: 100%;
            margin: auto;
            font-family: 'Quicksand', sans-serif !important;
            font-size: 14px !important;
            color: var(--bs-gray-900)
        }

        a {
            color: #0d6efd;
            text-decoration: none !important;
            cursor: pointer !important;
            transition: .3s
        }

        a:hover {
            color: var(--bs-danger);
            text-decoration: none !important
        }
    </style>

</head>
<body class="bg-light">

    <div class="position-relative vh-100">
        <div class="position-absolute top-50 start-50 translate-middle fs-3 text-dark-emphasis text-center">
            Oops!! an error occurred while running the application<br />
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>