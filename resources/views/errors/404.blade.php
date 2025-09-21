<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" href="https://sia.uici.ac.id/images/uici/logo-uici-baru.png">
    <link rel="shortcut icon" type="image/x-icon" href="https://sia.uici.ac.id/images/uici/logo-uici-baru.png">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 Not Found - SIA UICI</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Eczar:800&display=swap');
        @import url('https://fonts.googleapis.com/css?family=Poppins:600&display=swap');

        :root {
            --background-color: #F0FFF4;
            --text-color: #22c55e;
            --accent-color: #38A169;
            --subtle-color: #15803d;
            --hover-background: #14B8A6;
            --link-color: #38A169;
        }

        body {
            font-family: "Poppins", sans-serif;
            height: 100vh;
            background-color: var(--background-color);
            color: var(--text-color);
            padding: 1em;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .background-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            user-select: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .background-wrapper h1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-family: "Eczar", serif;
            font-size: 60vmax;
            color: var(--subtle-color);
            letter-spacing: 0.025em;
            margin: 0;
            transition: 750ms ease-in-out;
        }

        a {
            border: 2px solid var(--accent-color);
            padding: 0.5em 0.8em;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 10;
            color: var(--link-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            border-radius: 9999px;
            transition: 150ms ease-in-out;
        }

        a svg polyline {
            transition: 150ms ease-in-out;
        }

        a:hover {
            color: var(--background-color);
            background: var(--link-color);
            border-color: transparent;
        }

        a:hover svg polyline {
            stroke: var(--background-color);
        }

        a:hover+.background-wrapper h1 {
            color: var(--text-color);
        }

        p {
            color: var(--text-color);
            font-size: calc(1em + 3vmin);
            position: fixed;
            bottom: 1rem;
            right: 1.5rem;
            margin: 0;
            text-align: right;
            text-shadow: -1px -1px 0 var(--background-color), 1px 1px 0 var(--background-color), -1px 1px 0 var(--background-color), 1px -1px 0 var(--background-color);
            z-index: 5;
        }

        @media screen and (min-width: 340px) {
            p {
                width: 70%;
            }
        }

        @media screen and (min-width: 560px) {
            p {
                width: 50%;
            }
        }

        @media screen and (min-width: 940px) {
            p {
                width: 30%;
            }
        }

        @media screen and (min-width: 1300px) {
            p {
                width: 25%;
            }
        }
    </style>
</head>

<body>
    <a href="/">
        <svg height="0.8em" width="0.8em" viewBox="0 0 2 1" preserveAspectRatio="none" class="mr-2">
            <polyline fill="none" stroke="currentColor" stroke-width="0.1" points="0.9,0.1 0.1,0.5 0.9,0.9" />
        </svg> Beranda
    </a>
    <div class="background-wrapper">
        <h1 id="visual">404</h1>
    </div>
    <p>Halaman yang Anda cari tidak dapat ditemukan.</p>

    <script>
        const visual = document.getElementById("visual");
        const events = ['resize', 'load'];

        events.forEach(function(e) {
            window.addEventListener(e, function() {
                const width = window.innerWidth;
                const height = window.innerHeight;
                const ratio = 45 / (width / height);
                visual.style.transform = `translate(-50%, -50%) rotate(-${ratio}deg)`;
            });
        });
    </script>
</body>

</html>
