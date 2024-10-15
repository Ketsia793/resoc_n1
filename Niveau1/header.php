<?php 
    isset($_SESSION['connected_id'])
?>

<header>
    <a href='admin.php'><img src="resoc.jpg" alt="Logo de notre réseau social" /></a>
    <nav id="menu">
        
        <?php
        if (isset($_SESSION['connected_id'])) { ?>
            <a href="news.php">Actualités</a>
            <a href="wall.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mur</a>
            <a href="feed.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Flux</a>
            <a href="tags.php?tag_id=1">Mots-clés</a>
        <?php } ?>
    </nav>
    <nav id="user">
        <?php 
            if (! isset($_SESSION['connected_id'])) { ?>
                <a href="login.php">Se connecter</a>
        <?php } 
        else { ?>
        <a href="#">▾ Profil</a>
        <ul>
            <li><a href="settings.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Paramètres</a></li>
            <li><a href="followers.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mes suiveurs</a></li>
            <li><a href="subscriptions.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mes abonnements</a></li>
            <li><a href="logout.php">Se déconnecter</a></li>
        </ul>
        <?php } ?>
    </nav>
</header>