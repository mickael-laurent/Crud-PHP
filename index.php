<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Crud en php</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-wp-preserve="%3Cscript%20src%3D%22js%2Fbootstrap.js%22%3E%3C%2Fscript%3E" data-mce-resize="false" data-mce-placeholder="1" class="mce-object" width="20" height="20" alt="<script>" title="<script>" />


</head>

<body>

    <div class="container">
        <div class="row">
            <h2>Crud en Php</h2>
        </div>


        <div class="row">
            <p>
                <a href="add.php" class="btn btn-success">Ajouter un user</a>
                <a href="logout.php" class="btn btn-danger">Deconnexion</a>
            </p>
            <div class="table-responsive">

                <table class="table table-hover table-bordered">

                    <thead>

                        <th>Name</th>

                        <th>Firstname</th>

                        <th>Age</th>

                        <th>Tel</th>

                        <th>Pays</th>

                        <th>Email</th>

                        <th>Comment</th>

                        <th>metier</th>

                        <th>Url</th>

                        <th>Edition</th>

                    </thead>

                    <tbody>
                        <?php
                        //on inclut notre fichier de connection 
                        include 'database.php';
                        //on se connecte à la base 
                        $pdo = Database::connect();
                        $sql = 'SELECT * FROM user ORDER BY id DESC';
                        //on formule notre requete  
                        foreach ($pdo->query($sql) as $row) {
                            //on cree les lignes du tableau avec chaque valeur retournée 

                            echo '<tr>';

                            echo '<td>' . $row['name'] . '</td>';

                            echo '<td>' . $row['firstname'] . '</td>';

                            echo '<td>' . $row['age'] . '</td>';

                            echo '<td>' . $row['tel'] . '</td>';

                            echo '<td>' . $row['email'] . '</td>';

                            echo '<td>' . $row['pays'] . '</td>';

                            echo '<td>' . $row['comment'] . '</td>';

                            echo '<td>' . $row['metier'] . '</td>';

                            echo '<td>' . $row['url'] . '</td>';


                            echo '<td>';
                            echo '<a class="btn btn-light" href="edit.php?id=' . $row['id'] . '">Read</a>'; // un autre td pour le bouton d'edition
                            echo '</td>';


                            echo '<td>';
                            echo '<a class="btn btn-success" href="update.php?id=' . $row['id'] . '">Update</a>'; // un autre td pour le bouton d'update
                            echo '</td>';


                            echo '<td>';
                            echo '<a class="btn btn-danger" href="delete.php?id=' . $row['id'] . ' ">Delete</a>'; // un autre td pour le bouton de suppression
                            echo '</td>';


                            echo '</tr>';
                        };
                        Database::disconnect(); //on se deconnecte de la base

                        ?>
                    </tbody>


                </table>


            </div>



        </div>



    </div>


</body>

</html>