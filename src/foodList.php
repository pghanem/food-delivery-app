<?php
    require 'includes/dbHandler.inc.php';
    require 'includes/executes.inc.php'; 
    // require 'header.php';
    
    // require 'includes/reviewCalc.inc.php';
    // update();
?>
<link rel="stylesheet" href="style.css">
<div class="container">
    <div class="row">
        <div class="col align-self-end">
            <form class="form-inline" action="foodList.php" method="post">
        
                <label class="my-1 mr-2" for="mealTypeSelector">Type:</label>
                <select class="custom-select my-1 mr-sm-2" id="mealTypeSelector" name="meal-type">
                    <option selected>Choose...</option>
                    <option value="Breakfast">Breakfast</option>
                    <option value="Lunch">Lunch</option>
                    <option value="Side">Side</option>
                    <option value="Main">Main</option>
                    <option value="Drink">Drink</option>
                    <option value="Dessert">Dessert</option>
                    <option value="Kids Menu">Kids Menu</option>
                </select>
        
        
                <div class="btn-group btn-group-toggle mx-1" data-toggle="buttons" name="restrictionSelector">
                    <label class="btn btn-secondary none">
                        <input type="radio" name="options" id="option1" autocomplete="off" value="None"> None
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="options" id="option1" autocomplete="off" value="Vegetarian"> Vegetarian
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="options" id="option2" autocomplete="off" value="Vegan"> Vegan
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="options" id="option3" autocomplete="off" value="Gluten-Free"> Gluten-Free
                    </label>
                </div>
        
                <button type="submit" class="btn btn-primary" name="sort-submit">Submit</button>
        
                </form>
            
        </div>
    </div>
    </div>
    
</div>

<?php
// require 'includes/foodList.inc.php';
        // update();
    printFoodCards();

    function getSQL() {
        $baseSQL = "select f.name, f.price, f.description, r.name as rname, r.avg_rating as rating from FoodItem f inner join restaurant r on f.RID=r.RID";

        $where = array();
        $orderBy ="";
        $direction = "";

        if (isset($_POST['sort-submit'])) {
            if (isset($_POST['options']) && $_POST['options'] !== "None") {
                $restriction = $_POST['options'];
                $object = (object) ['clause'=>'f.dietary_type',
                                    'value' => $restriction];
                $where[] = $object;
            }

            if (isset($_POST['meal-type'])) {
                $meal = $_POST['meal-type'];
                if ($meal !== 'Choose...') {
                    $object = (object) ['clause'=>'category',
                                        'value' => $meal];
                    $where[] = $object;
                }
            }
        }

        $sql = $baseSQL;

        $whereLength = count($where);

        if ($whereLength > 0) {
            $first = true;
            $whereSQL = " where ";
            for ($x = 0; $x < $whereLength; $x++) {
                if (!$first) {
                    $whereSQL = $whereSQL . " and ";
                }
                $whereSQL = $whereSQL . $where[$x]->clause . "='".$where[$x]->value."'";
                $first = false;
            }
            $sql = $sql . $whereSQL;
        }

        return $sql;
    }
    
    function printFoodCards() {
        $sql = getSQL();
        $result = executePlainSQL($sql);
        printCards($result);
    }
    
    function printCards($result) {
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<div class='container'>";
            echo "	<div class='card foodCard'>";
            echo "  	<div class='card-body'>";
            echo "     		<h5 class='card-title'>" . $row['NAME'];
            echo "          	<small class='text-muted'>". $row['RNAME'] . "</small>";
            echo "       	</h5>";
            echo "       	<h5 class='price'>$". $row['PRICE'] ."</h5>";
            echo "       	<h5 class='rating'>". $row['RATING'];
            echo "       	    <i class='fas fa-star'></i>";
            echo "          </h5>";
            echo "       	<p class='card-text'>". $row['DESCRIPTION'] .".</p>";
            echo "   	</div>";
            echo "	</div>";
            echo "</div>";
        }
    }

    function addWhere($where) {
        $first =true;
        $whereSQL = " where ";
            for ($x = 0; $x < $whereLength; $x++) {
                if (!$first) {
                    $whereSQL = $whereSQL . " && ";
                }
                $whereSQL = $whereSQL . $where[$x]->clause . "='".$where[$x]->value."'";
            }
        return $whereSQL;
    }

?>

