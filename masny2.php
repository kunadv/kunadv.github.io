 <!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>ZGŁOSZENIA</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <header>
        <h1>Zgłoszenia wydarzeń</h1>
    </header>

    <main>
        <section>
            <h2>Personel</h2>
            <form action="index.php" method="POST">
                <input type="radio" name="opcja" value="policjant" checked> Policjant
                <input type="radio" name="opcja" value="ratownik"> Ratownik
                <button type="submit">Pokaż</button>
            </form>

            <?php
            // Skrypt 1
            $db = mysqli_connect('localhost', 'root', '', 'zgloszenia');

            $wybranaOpcja = 'policjant';
            if (isset($_POST['opcja'])) {
                $wybranaOpcja = $_POST['opcja'];
            }

            echo "<h3>Wybrano opcję: $wybranaOpcja</h3>";

            $zapytanie1 = "SELECT id, imie, nazwisko FROM personel WHERE status = '$wybranaOpcja'";
            $wynik1 = mysqli_query($db, $zapytanie1);

            echo "<table>";
            echo "<tr><th>Id</th><th>Imię</th><th>Nazwisko</th></tr>";
            while ($row = mysqli_fetch_row($wynik1)) {
                echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td></tr>";
            }
            echo "</table>";
            ?>
        </section>

        <section>
            <h2>Nowe zgłoszenie</h2>
            <ol>
                <?php
                // Skrypt 2
                $zapytanie3 = "SELECT id, nazwisko FROM personel WHERE id NOT IN (SELECT id_personel FROM rejestr)";
                $wynik3 = mysqli_query($db, $zapytanie3);

                while ($row3 = mysqli_fetch_row($wynik3)) {
                    echo "<li>$row3[0] $row3[1]</li>";
                }
                ?>
            </ol>

            <form action="index.php" method="POST">
                <label for="id_osoby">Wybierz id osoby z listy: </label>
                <input type="number" name="id_osoby" id="id_osoby">
                <input type="submit" value="Dodaj zgłoszenie">
            </form>

            <?php
            // Skrypt 3
            if (isset($_POST['id_osoby']) && !empty($_POST['id_osoby'])) {
                $idOsoby = $_POST['id_osoby'];
                $zapytanie4 = "INSERT INTO rejestr (id, data, id_personel, id_pojazd) VALUES (NULL, CURRENT_DATE(), $idOsoby, 14)";
                mysqli_query($db, $zapytanie4);
            }

            // Zamknięcie połączenia z bazą na końcu (wymóg arkusza)
            mysqli_close($db);
            ?>
        </section>
    </main>

    <footer>
        <p>Stronę wykonał: 00000000000</p> <!-- Zastąp swoim numerem zdającego (PESEL) -->
    </footer>
</body>
</html>