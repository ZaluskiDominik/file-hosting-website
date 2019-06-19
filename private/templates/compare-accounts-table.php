<?php 
require_once($phpPaths['PHP'] . '/compare-accounts-table-content.php');
$acc = ( new compareAccountsTableContent() )->get();
?>

<div class="compareAccountsTable">
<table>
    <tr>
        <th></th>
        <th>Gość</th>
        <th>Zarejestrowany</th>
        <th>Premium</th>
    </tr>

    <tr>
        <td>Miejsce na dysku</td>
        <td><?php echo $acc['guest']['upload']['maxStorageSize']; ?></td>
        <td><?php echo $acc['regular']['upload']['maxStorageSize']; ?></td>
        <td><?php echo $acc['premium']['upload']['maxStorageSize']; ?></td>
    </tr>
    
    <tr>
        <td>Maksymalny rozmiar pliku</td>
        <td><?php echo $acc['guest']['upload']['maxFileSize']; ?></td>
        <td><?php echo $acc['regular']['upload']['maxFileSize']; ?></td>
        <td><?php echo $acc['premium']['upload']['maxFileSize']; ?></td>
    </tr>
    
    <tr>
        <td>Maksymalna liczba plików naraz</td>
        <td><?php echo $acc['guest']['upload']['maxNum']; ?></td>
        <td><?php echo $acc['regular']['upload']['maxNum']; ?></td>
        <td><?php echo $acc['premium']['upload']['maxNum']; ?></td>
    </tr>

    <tr>
        <td>Maksymalna prędkość</td>
        <td><?php echo $acc['guest']['download']['maxSpeed']; ?></td>
        <td><?php echo $acc['regular']['download']['maxSpeed']; ?></td>
        <td><?php echo $acc['premium']['download']['maxSpeed']; ?></td>        
    </tr>

    <tr>
        <td>
            Liczba pobrań na 
            <?php echo round($downloadConf['MAX_NUM_DURATION'] / 3600); ?> 
            minut
        </td>
        <td><?php echo $acc['guest']['download']['maxNum']; ?></td>
        <td><?php echo $acc['regular']['download']['maxNum']; ?></td>
        <td><?php echo $acc['premium']['download']['maxNum']; ?></td>        
    </tr>
</table>
</div>