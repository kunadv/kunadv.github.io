<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wyszukiwarka miast</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="fav.png">
</head>
<body>

    <header>
        <img src="baner.jpg" alt="Polska">
    </header>

    <div class="left-top">
        <h4>Podaj początek nazwy miasta</h4>
        <form action="index.php" method="post">
            <input type="text" name="filtr">
            <input type="submit" value="Szukaj">
        </form>
    </div>

    <main>
        <h1>Wyniki wyszukiwania miast z uwzględnieniem filtra:</h1>
        <?php
        if (isset($_POST['filtr'])) {
            $filtr = $_POST['filtr'];
            
            echo "<p class='filter-text'>" . htmlspecialchars($filtr) . "</p>";

            $conn = mysqli_connect("localhost", "root", "", "wykaz");

            if ($conn) {
                $query = "SELECT wykaz_miasta.nazwa AS miasto, wykaz_wojewodztwa.nazwa AS wojewodztwo 
                          FROM wykaz_miasta 
                          JOIN wykaz_wojewodztwa ON wykaz_miasta.id_wojewodztwa = wykaz_wojewodztwa.id 
                          WHERE wykaz_miasta.nazwa LIKE '$filtr%' 
                          ORDER BY wykaz_miasta.nazwa ASC;";

                $result = mysqli_query($conn, $query);

                if ($result) {
                    echo "<table>";
                    echo "<tr><th>Miasto</th><th>Województwo</th></tr>";

                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['miasto'] . "</td>";
                        echo "<td>" . $row['wojewodztwo'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                }

                mysqli_close($conn);
            }
        }
        ?>
    </main>

    <div class="left-bottom">
        <p>Egzamin INF.03</p>
        <p>Autor: 00000000000</p>
    </div>

</body>
</html>