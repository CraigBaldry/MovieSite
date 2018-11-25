<?php

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
    $temp = '';
    $nameArray = array('Title', 'Genre', 'Rating', 'Year');
    $userInput = [filter_var($_GET["title"], FILTER_SANITIZE_STRING), filter_var($_GET["genre"], FILTER_SANITIZE_STRING), filter_var($_GET["rating"], FILTER_SANITIZE_STRING), filter_var($_GET["year"], FILTER_SANITIZE_STRING)];

    //Loop through values and build query string
    for ($i = 0; $i < count($nameArray); $i++) {
        if (empty($userInput[$i]) === false) {
            $condition = mysqli_real_escape_string($conn, $userInput[$i]);            
            $temp .= $nameArray[$i] . ' LIKE \'' . $condition . '%\' OR '
                    . $nameArray[$i] . ' = \'' . $condition . '\' AND ';
        }
    }

    $where = substr($temp, 0, -5);
    echo $where;
    if (empty($where) == true) {
        echo '<br> No search parameters entered';
    } else {
        $sql = 'SELECT * FROM movies WHERE ' . $where;
        echo '<br>' . $sql;
        if ($result = mysqli_query($conn, $sql)) {
            if ($result->num_rows > 0) {

                echo "<table id='searchTable'>";
                echo "<thead>
                                <tr>
                                    <th scope='col'>ID #</th>
                                    <th scope='col'>Title</th>
                                    <th scope='col'>Studio</th>
                                    <th scope='col'>Status</th>
                                    <th scope='col'>Sound</th>
                                    <th scope='col'>Versions</th>
                                    <th scope='col'>RecRetPrice</th>
                                    <th scope='col'>Rating</th>
                                    <th scope='col'>Year</th>
                                    <th scope='col'>Genre</th>
                                    <th scope='col'>Aspect</th>
                                </tr>
                            </thead>
                            <tbody>";
                // output data of each row
                while ($record = mysqli_fetch_row($result)) {
                    $condition = mysqli_real_escape_string($conn, $record[1]);
                    $updateCounter = 'UPDATE movies Set SearchCount= SearchCount + 1'
                            . ' WHERE Title = \'' . $condition . '\'';
                    mysqli_query($conn, $updateCounter);

                    echo '<tr>'
                    . '<td>' . $record[0] . '</td>'
                    . '<td>' . $record[1] . '</td>'
                    . '<td>' . $record[2] . '</td>'
                    . '<td>' . $record[3] . '</td>'
                    . '<td>' . $record[4] . '</td>'
                    . '<td>' . $record[5] . '</td>'
                    . '<td>' . $record[6] . '</td>'
                    . '<td>' . $record[7] . '</td>'
                    . '<td>' . $record[8] . '</td>'
                    . '<td>' . $record[9] . '</td>'
                    . '<td>' . $record[10] . '</td>'
                    . '</tr>';
                }
                echo '</tbody>';
                echo '</table>
                <br>';
            } else {
                echo '<br> 0 results';
            }
        } else {
            echo '<br> No data to search';
        }
    }
    $conn->close();
}
?>