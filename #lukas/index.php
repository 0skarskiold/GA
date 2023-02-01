<?php 
    session_start(); // tillåter sessions
    require_once("conn/dbh.php"); // connect:ar till servern

    // hämtar funktioner för sidan
    require_once("index_functions.php");
    
    require_once("section_contents.php"); // html-head, kopplar css och js
?>

<body id="index">
    <?php include_once("section_header.php"); // html header ?> 

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

    <?php include_once("section_footer.php"); ?>
</body>
</html>