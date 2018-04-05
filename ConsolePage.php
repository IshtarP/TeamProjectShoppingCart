<html>
    <head>
        <style>
            @import url(css/styles.css);
        </style>
        <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
    </head>
    <body class="main">
        <div class="container">
            <h1> Console </h1>
            <div class="box2">
                <h3>Search by:</h3>
                <form >
                    Title: <input type="text" name="product" /><br/><br/>
                    <select id="dropdown" name="filter">
                        <option value="">Filter by...</option>
                        <option value="console_title">Title</option>
                        <option value="console_genre">Genre</option>
                        <option value="console_price">Price</option>
                        <option value="console_rating">Rating</option>
                    </select>
                    <br/><br/>
                    
                    <strong>Price:  From</strong> <input type="text" name="priceFrom"/>
                    <strong>To</strong> <input type="text" name="priceTo"/>
                    <br/><br/>
                    
                    <input type="radio" name="order" value="ASC"><strong>Asc</strong>
                    <input type="radio" name="order" value="DESC"><strong>Desc</strong>
                    <br/><br/>
                    
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
                    
                    $conn = getDatabaseConnection("heroku_34a8e5c8c0df63e");
                    
                    $sql = "SELECT * FROM console WHERE 1";
                    
                    if(isset($_GET['submit']))
                    {
                        if(!empty($_GET['product'])) 
                        {
                            
                            $sql .= " AND console_title LIKE '%" . $_GET['product'] . "%'";
                        }
                        
                        if(!empty($_GET['priceFrom'])) 
                        {
                            
                            $sql .= " AND console_price >= " . $_GET['priceFrom'];
                        }
                        
                        if(!empty($_GET['priceTo'])) 
                        {
                            
                            $sql .= " AND console_price <= " . $_GET['priceTo'];
                        }
                        
                        if(!empty($_GET['filter']))
                        {
                            $sql .= " ORDER BY " . $_GET['filter'];
                        }
                        
                        else 
                        {
                            $sql .= " ORDER BY console_title";
                        }
                        
                        if(isset($_GET['order']))
                        {
                            $sql .= " " . $_GET['order'];
                        }
                    }
                    else
                    {
                        $sql .= " ORDER BY console_title";
                    }
                    if (!empty($_GET['product'])) 
                    { //checks whether user has typed something in the "Product" text box
                        $sql .=  " AND console_title LIKE :productName";
                        $namedParameters[":productName"] = "%" . $_GET['product'] . "%";
                    }
                    
                    
                    //echo $sql;
                    $stmt = $conn->prepare($sql);
                    $stmt->execute($namedParameters);
                    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Image</th>";
                    echo "</tr>";
                    
                    foreach($records as $record) 
                    {
                        echo "<tr>";
                        echo "<td> <img src='" . $record['console_image'] . "' width='200' height='300' alt='" . $record['console_title'] . "'/></td><br/>";
                        echo "<td><button class='accordion' >". $record['console_title']  . "</button>";
                        echo "<div id='panel'>";
                        
                        echo "<h4>Summary:</h4>";
                        echo "<p id='description'>";
                        echo $record['console_description'];
                        echo "</br >";
                        echo "<h4>Genre:</h4>";
                        echo $record['console_genre'];
                        echo "</br >";
                        echo "<h4>Price:</h4>";
                        echo $record['console_price'];
                        echo "</p>";
                        
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                ?>
            </div>
        </div>
    <script>
    var acc = document.getElementsByClassName("accordion");
    var i;
    
    for (i = 0; i < acc.length; i++) 
    {
        acc[i].onclick = function()
        {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") 
            {
                panel.style.display = "none";
            }
            else 
            {
                panel.style.display = "block";
            }
        }
    }
    </script>
    </body>
</html>
