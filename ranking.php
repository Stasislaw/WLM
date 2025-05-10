
<?php
require_once('header.php'); 
session_start();
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking - Ligia Matematyczna</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main class="container">
        <section class="ranking">
            <h2>Ranking Uczestników</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nazwa</th>
                        <th>Punkty</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Jan Kowalski</td>
                        <td>150</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Anna Nowak</td>
                        <td>140</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>