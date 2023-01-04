<?php
function ordinal($int = 1)
{
    $last_digit = substr($int, -1, 1);
    switch ($last_digit) {
        case 1:
            $str = $int . "er";
            break;
        case 2:
            $str = $int . "do";
            break;
        case 3:
            $str = $int . "ro";
            break;
        default:
            $str = $int . "to";
            break;
    }
    return $str;
}
?>
<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 mx-auto">
    <h2 class="text-light pt-5 pb-2  text-center">Ganador@s</h2>
    <hr>

    <div class="card rounded-0">
        <div class="card-header rounded-0">
            <div class="d-flex justify-content-between align-items-end">
                <div class="col-auto flex-shrink-1 flex-grow-1">
                    <div class="card-title"><b>Lista de Ganadores</b></div>
                </div>
                <div class="col-auto">
                </div>
            </div>
        </div>
        <div class="card-body rounded-0">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <colgroup>
                            <col width="20%">
                            <col width="30%">
                            <col width="50%">
                        </colgroup>
                        <thead>
                            <tr class="bg-danger bg-gradient text-white">
                                <th class="text-center">Turno</th>
                                <th class="text-center">Código</th>
                                <th class="text-center">Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include_once("db-connect.php"); ?>
                            <?php
                            $qry = $conn->query("SELECT t.*, w.draw FROM `winners` w inner join `tickets` t on w.ticket_id = t.id order by abs(w.`draw`) asc");
                            if ($qry->num_rows > 0) :
                                $i = 1;
                                while ($row = $qry->fetch_assoc()) :
                            ?>
                                    <tr>
                                        <th class="text-center"><?= ordinal($row['draw']) ?></th>
                                        <td><?= $row['code'] ?></td>
                                        <td><?= $row['name'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                            <?php endif; ?>
                            <?php $conn->close(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>