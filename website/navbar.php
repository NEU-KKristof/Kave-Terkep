<?php 

?>
<!DOCTYPE html>
<body>
<header>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        header {
            background: linear-gradient(to right, #3c2f2f, #6b4e31);
            color: white;
            text-align: center;
            padding: 40px 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        header h1 {
            font-size: 2.8em;
            animation: slideInFromTop 1s ease-out;
        }
        nav {
            background: #6b4e31;
            padding: 15px 0;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 20px;
            font-weight: bold;
            font-size: 1.1em;
            transition: color 0.3s ease, transform 0.3s ease;
            position: relative;
        }
        nav a:hover {
            color: #d4a373;
            transform: scale(1.1);
        }
        nav a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: #d4a373;
            bottom: -5px;
            left: 0;
            transition: width 0.3s ease;
        }
        nav a:hover::after {
            width: 100%;
        }

        .h1xxx {
            color: white;
        }

    </style>
        <h1 class="h1xxx">Kávé Világ</h1>
    </header>
    <nav>
        <a href="index.php" >Térkép</a>
        <a href="rolunk.php" >Rólunk</a>
        <a href="login.php" id="login-link">Bejelentkezés</a>
        <a href="signup.php" id="signup-link">Regisztráció</a>
    </nav>
</body>
</html>