<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="container">
        <div class="coffee-cup">

        </div>
        <div class="handle">

        </div>
    </div>

    <h2 class="container">NGOPI SEK BROWS</h2>

</body>

</html>
<style>
    h2 {
        font-family: Arial, Helvetica, sans-serif;
        color: #fff;
        top: 360px !important;
    }

    body {
        background-color: rgb(26, 23, 23);
    }

    .container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .coffee-cup {
        position: relative;
        width: 100px;
        height: 80px;
        box-sizing: border-box;
        border: 7px solid #fff;
        border-radius: 5px 5px 48px 48px;
        background: none;
        overflow: hidden;
    }

    .handle {
        position: absolute;
        top: 5px;
        left: 95px;
        width: 30px;
        height: 48px;
        background: transparent;
        box-sizing: border-box;
        border: 5px solid #fff;
        border-radius: 0 10px 25px 0;
    }

    .coffee-cup::before {
        content: '';
        position: absolute;
        top: 25px;
        left: -60px;
        height: 200px;
        width: 200px;
        background: saddlebrown;
        border-radius: 70px;
        animation: loading 5s linear infinite;
    }

    @keyframes loading {
        0% {
            transform: rotate(0);
        }

        100% {
            transform: rotate(360deg);
        }

    }
</style>