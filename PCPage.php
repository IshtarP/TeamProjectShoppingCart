<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>
    <body class="main">
        <div class="container">
            <h1>Better GameStahp</h1>
            <div class="formDiv">
                <form >
                    <select id="dropdown" name="filter">
                        <option value="">Filter by...</option>
                        <option value="pc_title">Title</option>
                        <option value="pc_genre">Genre</option>
                        <option value="pc_price">Price</option>
                        <option value="pc_rating">Rating</option>
                    </select>
                    <br/><br/>
                    
                    Price:  From <input type="text" name="priceFrom"/>
                    To   <input type="text" name="priceTo"/>
                    <br/><br/>
                    
                    <input type="radio" name="order" value="ASC">Asc
                    <input type="radio" name="order" value="DESC">Desc
                    <br/><br/>
                    
                    <input type="submit" value="Search" name="submit">
                </form>
                
                <form action="CartPage.php">
                    <input type="submit" name="cart" value="Shopping Cart">
                </form>
                
                <form action="HomePage.php">
                    <input type="submit" value="Back to home">
                </form>
            </div>
            
            <div class="textDiv">
                <?php
                    include 'database.php';
                    
                    $conn = getDatabaseConnection("heroku_34a8e5c8c0df63e");
                    
                    $sql = "SELECT * FROM pc WHERE 1";
                    
                    if(isset($_GET['submit'])){
                        if(!empty($_GET['filter']))
                        {
                            $sql .= " ORDER BY " . $_GET['filter'];
                        }
                        else {
                            $sql .= " ORDER BY pc_title";
                        }
                        
                        if(isset($_GET['order']))
                        {
                            $sql .= " " . $_GET['order'];
                        }
                    }
                    else{
                        $sql .= " ORDER BY pc_title";
                    }
                    
                    
                    
                    //echo $sql;
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Image</th>";
                    echo "<th>Title</th>";
                    echo "<th>Genre</th>";
                    echo "<th>Price</th>";
                    echo "</tr>";
                    
                    foreach($records as $record) {
                        echo "<tr>";
                        echo "<td> <img src='" . $record['pc_image'] . "' width='200' height='300' alt='" . $record['pc_title'] . "'/></td><br/>";
                        echo "<td><button class='accordion'>". $record['pc_title'] ."</button>";
                        echo "<div class='panel'>";
                        
                        echo "<h4>Summary:</h4>";
                        echo "<p>";
                        //echo $record['pc_description'];
                        echo "</p>";
                        
                        echo "</div>";
                        echo "</td>";
                        echo "<td>". $record['pc_genre'] ."</td>";
                        echo "<td>". $record['pc_price'] ."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    
                ?>
            </div>
        </div>
    <script>
    var acc = document.getElementsByClassName("accordion");
    var i;
    
    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function(){
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        }
    }
    </script>
    </body>
</html>
