<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wodospady</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

    <header>
        <h2>Łowcy wodospadów</h2>
    </header>

    <main>
        <aside>
            <!-- Skrypt 1 -->
            <?php
            $polaczenie = mysqli_connect('localhost', 'root', '', 'wodospady');
            $zapytanie1 = "SELECT idKontynent, nazwa FROM kontynenty;";
            $wynik1 = mysqli_query($polaczenie, $zapytanie1);

            while ($wiersz = mysqli_fetch_array($wynik1)) {
                echo "<a href='index.php?id=" . $wiersz['idKontynent'] . "'>" . $wiersz['nazwa'] . "</a>";
            }
            mysqli_close($polaczenie);
            ?>
        </aside>

        <section>
            <!-- Skrypt 4 - Obsługa formularza (wstawianie osiągnięcia) -->
            <?php
            if (isset($_POST['idObiekt']) && isset($_POST['idTurysta'])) {
                $idObiekt = $_POST['idObiekt'];
                $idTurysta = $_POST['idTurysta'];

                $polaczenie = mysqli_connect('localhost', 'root', '', 'wodospady');
                $zapytanie4 = "INSERT INTO osiagniecia (idObiekt, idTurysta) VALUES ($idObiekt, $idTurysta);";
                mysqli_query($polaczenie, $zapytanie4);
                mysqli_close($polaczenie);
            }
            ?>

            <!-- Skrypt 2 -->
            <table>
                <tr>
                    <th>Identyfikator</th>
                    <th>Państwo</th>
                    <th>Nazwa wodospadu</th>
                    <th>Wysokość</th>
                </tr>
                <?php
                $kontynent = 6;
                if (isset($_GET['id'])) {
                    $kontynent = $_GET['id'];
                }

                $polaczenie = mysqli_connect('localhost', 'root', '', 'wodospady');
                $zapytanie3 = "SELECT idObiekt, panstwo, nazwa, wartoscCechy FROM obiekty WHERE idRodzaj = 10 AND idKontynent = $kontynent;";
                $wynik3 = mysqli_query($polaczenie, $zapytanie3);

                while ($wiersz = mysqli_fetch_row($wynik3)) {
                    echo "<tr>";
                    echo "<td>" . $wiersz[0] . "</td>";
                    echo "<td>" . $wiersz[1] . "</td>";
                    echo "<td>" . $wiersz[2] . "</td>";
                    echo "<td>" . $wiersz[3] . "</td>";
                    echo "</tr>";
                }
                mysqli_close($polaczenie);
                ?>
            </table>

            <h4>Wpisz osiągnięcie do bazy</h4>
            <form action="index.php" method="POST">
                <label for="idObiekt">identyfikator wodospadu</label>
                <input type="number" name="idObiekt" id="idObiekt">
                
                <label for="idTurysta">turysta</label>
                <select name="idTurysta" id="idTurysta">
                    <!-- Skrypt 3 -->
                    <?php
                    $polaczenie = mysqli_connect('localhost', 'root', '', 'wodospady');
                    $zapytanie5 = "SELECT idTurysta, nick FROM turysci;";
                    $wynik5 = mysqli_query($polaczenie, $zapytanie5);

                    while ($wiersz = mysqli_fetch_array($wynik5)) {
                        echo "<option value='" . $wiersz['idTurysta'] . "'>" . $wiersz['nick'] . "</option>";
                    }
                    mysqli_close($polaczenie);
                    ?>
                </select>

                <button type="submit">Wpisz</button>
            </form>
        </section>
    </main>

    <article>
        <h3>Wodospady w Polsce</h3>
        <img src="kamienczyk.jpg" alt="wodospad">
        <img src="siklawica.jpg" alt="wodospad">
        <img src="siklawa.jpg" alt="wodospad">
        <img src="wilczki.jpg" alt="wodospad">
    </article>

    <footer>
        <p>Autor: 00000000000</p> <!-- Zastąp swoim numerem zdającego (PESEL) -->
    </footer>

</body>
</html>