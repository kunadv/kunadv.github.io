 <!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wykaz chorób</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

    <!-- Blok nagłówkowy -->
    <header>
        <h1>Informacja o chorobach w Polsce</h1>
    </header>

    <!-- Blok nawigacyjny -->
    <nav>
        <a href="https://szpitale.pl/" target="_blank">Szpitale</a>
        <a href="https://www.przychodnie.pl/" target="_blank">Przychodnie</a>
        <a href="https://www.nfz.gov.pl/" target="_blank">NFZ</a>
    </nav>

    <!-- Blok główny -->
    <main>
        <!-- Blok sekcji lewej -->
        <section>
            <h2>Choroby zakaźne</h2>
            <ol>
                <?php
                // Skrypt 1
                $polaczenie = mysqli_connect('localhost', 'root', '', 'choroby');
                $zapytanie1 = "SELECT nazwa FROM choroby WHERE zakazna = 'T' ORDER BY nazwa ASC;";
                $wynik1 = mysqli_query($polaczenie, $zapytanie1);
                while ($rekord = mysqli_fetch_row($wynik1)) {
                    echo "<li>$rekord[0]</li>";
                }
                mysqli_close($polaczenie);
                ?>
            </ol>
        </section>

        <!-- Blok sekcji prawej -->
        <section>
            <h2>Objawy chorób</h2>
            <form action="zdrowie.php" method="POST">
                <select name="wybrana_choroba">
                    <?php
                    // Skrypt 2
                    $polaczenie = mysqli_connect('localhost', 'root', '', 'choroby');
                    $zapytanie2 = "SELECT id, nazwa FROM choroby;";
                    $wynik2 = mysqli_query($polaczenie, $zapytanie2);
                    while ($rekord = mysqli_fetch_array($wynik2)) {
                        echo "<option value='$rekord[0]'>$rekord[1]</option>";
                    }
                    mysqli_close($polaczenie);
                    ?>
                </select>
                <button type="submit">Sprawdź</button>
            </form>

            <div>
                <?php
                // Skrypt 3
                if (isset($_POST['wybrana_choroba'])) {
                    $idChoroby = $_POST['wybrana_choroba'];
                    $polaczenie = mysqli_connect('localhost', 'root', '', 'choroby');
                    
                    $zapytanie3 = "SELECT objawy.nazwa FROM objawy JOIN choroby_objawy ON objawy.id = choroby_objawy.id_objawy WHERE choroby_objawy.id_choroby = $idChoroby;";
                    $wynik3 = mysqli_query($polaczenie, $zapytanie3);
                    
                    while ($rekord = mysqli_fetch_row($wynik3)) {
                        echo "<span> $rekord[0] </span>";
                    }
                    
                    mysqli_close($polaczenie);
                }
                ?>
            </div>
        </section>
    </main>

    <!-- Blok stopki -->
    <footer>
        <p>Stronę opracował: 12345678901</p> <!-- Wpisz swój numer zdającego (PESEL) -->
    </footer>

    <!-- Obraz poza blokami -->
    <img src="zdrowia.png" alt="Życzymy zdrowia!">

</body>
</html>