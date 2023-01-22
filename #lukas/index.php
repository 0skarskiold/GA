<?php 
    session_start(); // tillåter sessions
    require_once("includes/dbh.inc.php"); // connect:ar till servern

    // hämtar funktioner för sidan
    require_once("index_functions.php");
    
    require_once("sections/contents.php"); // html-head, kopplar css och js
?>

<body>
    <?php include_once("sections/header.php"); // html header ?> 

    <main>

        <?php 
            // om du är inloggad
            if(isset($_SESSION['userid'])) {
                $recent = fetchRecent($conn, $_SESSION['userid']);
                // om funktionen hittar aktivitet från de du följer
                renderListRecent($recent);
            } 

            $popular = fetchPopular($conn, 'all');
            renderListPopular($popular);
        ?> 

    </main>

    <?php include_once("sections/footer.php"); ?>
</body>
</html>