html>
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
                        <option value="Name">Title</option>
                        <option value="Genre">Genre</option>
                    </select>
                    
                    Price:  From <input type="text" name="priceFrom"/>
                    To   <input type="text" name="priceTo"/>
                    <input type="radio" name="order" value="ASC">Asc
                    <input type="radio" name="order" value="DESC">Desc
                    <input type="submit" value="Search" name="submit">
                </form>
                
                <form action="cart.php">
                    <input type="submit" name="cart" value="Shopping Cart">
                </form>
                
                <form action="HomePage.php">
                    <input type="submit" value="Back to home">
                </form>
            </div>
            
            <div class="textDiv">
                <?php
                    include 'database.php';
                    
                    $conn = getDatabaseConnection();
                    
                    $sql = "SELECT * FROM Console WHERE 1";
                    
                    if(isset($_GET['submit'])){
                        if(!empty($_GET['filter']))
                        {
                            $sql .= " ORDER BY " . $_GET['filter'];
                        }
                        else {
                            $sql .= " ORDER BY Name";
                        }
                        
                        if(isset($_GET['order']))
                        {
                            $sql .= " " . $_GET['order'];
                        }
                    }
                    else{
                        $sql .= " ORDER BY Name";
                    }
                    
                    
                    
                    //echo $sql;
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Title</th>";
                    echo "<th>Genre</th>";
                    //echo "<th>Director</th>";
                    echo "<th>Price</th>";
                    echo "</tr>";
                    
                    foreach($records as $record) {
                        echo "<tr>";
                        echo "<td><button class='accordion'>". $record["Name"] ."</button>";
                        echo "<div class='panel'>";
                        
                        echo "<h4>Summary:</h4>";
                        echo "<p>";
                        echo $record["Summary"];
                        echo "</p>";
                        
                        echo "</div>";
                        echo "</td>";
                        echo "<td>". $record["Genre"] ."</td>";
                        //echo "<td>". $record["Director"] ."</td>";
                        echo "<td>". $record["Price"] ."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    
                    // foreach($record as $rec)
                    // {
                    //     echo $rec['Name']."<br>";
                    // }
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
