<?php

$data;
$tempData;
// server info
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'moviesdb';

// Create connection
$conn = @mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    echo 'Database unavailable';
    // die("Connection failed: " . $conn->connect_error);
} else {
    //Loop through values and build query string
    $sql = 'SELECT * FROM movies WHERE SearchCount > 0 ORDER BY SearchCount ASC';
    if ($result = mysqli_query($conn, $sql)) {
        if ($result->num_rows > 0) {
            // output data of each row to an array
            while ($record = mysqli_fetch_row($result)) {
                $tempData[$record[1]] = $record[11];
            }
        } else {
            echo '<br> 0 results';
        }
    } else {
        echo '<br> No db';
    }
}
if (isset($tempData)) {
    $maxCount;
    //Sort array and create a new one with the highest value first
    arsort($tempData);
    foreach ($tempData as $key => $value) {
        $data[$key] = $value;
        if (count($data) == 10) {
            break;
        }else if(count($data) == 1) {
            $maxCount = $value;
        }
    }
    echo print_r($data);

// Image dimensions
    $imageWidth = 700;
    $imageHeight = 100 * count($data);

// Font settings
    $dir = dirname($_SERVER["SCRIPT_FILENAME"]);
    $font = $dir . '/arial.ttf';
    $fontSize = 10;

// Initialise image
    $chart = imagecreate($imageWidth, $imageHeight);



// Setup colors
    $backgroundColor = imagecolorallocate($chart, 255, 255, 255);
    $axisColor = imagecolorallocate($chart, 85, 85, 85);
    $labelColor = $axisColor;
    $gridColor = imagecolorallocate($chart, 212, 212, 212);
    $titleBoxColor = imagecolorallocate($chart, 255, 163, 26);
    $black = imagecolorallocate($chart, 0, 0, 0);

    // Grid dimensions and placement within image
    $gridTop = 40;
    $gridLeft = 300;
    $gridBottom = 940;
    $gridRight = 650;
    $gridHeight = $gridBottom - $gridTop;
    $gridWidth = $gridRight - $gridLeft;

    // Size of the bars
    $tick = $gridWidth / $maxCount;

    // Bar and line width
    $lineWidth = 1;
    $barWidth = 20;

    // Margin between label and axis
    $labelMargin = 8;

    // Spacing for labels
    $barSpacing = $gridHeight / count($data);
    $itemX = $gridTop + $barSpacing / 2;
    $itemCount = $gridTop + $barSpacing / 2;

    // Fill and set thickness
    imagefill($chart, 0, 0, $backgroundColor);
    imagesetthickness($chart, $lineWidth);

    //makes a random rgb value
    function createcolor($pic, $c1, $c2, $c3) {
        //get color from palette
        $color = imagecolorexact($pic, $c1, $c2, $c3);
        if ($color == -1) {
            //color does not exist...
            //test if we have used up palette
            if (imagecolorstotal($pic) >= 255) {
                //palette used up; pick closest assigned color
                $color = imagecolorclosest($pic, $c1, $c2, $c3);
            } else {
                //palette NOT used up; assign new color
                $color = imagecolorallocate($pic, $c1, $c2, $c3);
            }
        }
        return $color;
    }

    // Draw data as bar with label
    foreach ($data as $key => $value) {
        //assign random rgb values
        $c1 = mt_rand(50, 200); //r(ed)
        $c2 = mt_rand(50, 200); //g(reen)
        $c3 = mt_rand(50, 200); //b(lue)
        //generate color
        $barColor = createcolor($chart, $c1, $c2, $c3);

        // Draw the bar
        $y1 = $itemX + $barWidth;
        $x1 = $gridLeft;
        $y2 = $itemX - $barWidth;
        $x2 = $gridLeft + ($tick * $value);
        imagefilledrectangle($chart, $x1, $y1, $x2, $y2, $barColor);

        // Draw the label
        $labelBox = imagettfbbox($fontSize, 0, $font, $key);
        $labelWidth = $labelBox[4] - $labelBox[0];
        $labelX = $gridLeft - $labelWidth - $labelMargin;
        $labelY = $itemX + $fontSize / 2;
        imagettftext($chart, $fontSize, 0, $labelX, $labelY, $labelColor, $font, $key);
        $itemX += $barSpacing;

        // Draw the label
        $labelBox1 = imagettfbbox($fontSize, 0, $font, $value);
        $labelWidth1 = $labelBox1[4] - $labelBox1[0];
        $labelX1 = $x2 + $barWidth;
        $labelY1 = $y2 + $barWidth;
        imagettftext($chart, $fontSize, 0, $labelX1, $labelY1, $labelColor, $font, $value);
        $itemCount += $barSpacing;
    }

    // Draw y-axis
    imageline($chart, $gridLeft, $gridTop, $gridLeft, $gridBottom, $axisColor);

    //Title box and the labels for the x and y axis. 
    $title = 'Top 10 Searched Chart';

    // Add the text
    imagettftext($chart, 16, 0, 200, 30, $black, $font, $title);

    // Add a rectangle
    imagerectangle($chart, 195, 10, 495, 35, $titleBoxColor);

    // Output image to browser
    imagepng($chart, "outputImage.png");
    imagedestroy($chart);
    echo '<img src=outputImage.png>';
} else {
    echo '<br>data array returned null';
}
$conn->close();
?>