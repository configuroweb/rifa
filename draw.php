<?php include_once("db-connect.php"); ?>
<?php
$draw_qry = $conn->query("SELECT * FROM `winners` order by abs(`draw`) desc limit 1");
$draw = 1;
if ($draw_qry->num_rows) {
    $draw = $draw_qry->fetch_assoc()['draw'] + 1;
}
function ordinal($int = 1)
{
    $last_digit = substr($int, -1, 1);
    switch ($last_digit) {
        case 1:
            $str = $int . "st";
            break;
        case 2:
            $str = $int . "nd";
            break;
        case 3:
            $str = $int . "rd";
            break;
        default:
            $str = $int . "th";
            break;
    }
    return $str;
}
$draw_text = (ordinal($draw)) . " Intento";
?>
<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 mx-auto h-100 d-flex flex-column justify-content-center align-items-center">
    <div id="raffle-draw" class="w-100">
        <input type="hidden" id="rdraw" value="<?= $draw ?>">
        <input type="hidden" id="draw_text" value="<?= $draw_text ?>">
        <h2 class="text-center text-light" style="text-shadow:2px 2px 5px #000"><b><?= $draw_text ?></b></h2>
        <hr>
        <div id="ticket-list" class="d-flex overflow-hidden">
            <?php
            $highlight = false;
            $where = "";
            if (!isset($_GET['include_winners']))
                $where = " where id not in (SELECT id FROM `winners`)";

            $qry = $conn->query("SELECT * FROM `tickets` {$where} order by `name` asc");
            if ($qry->num_rows > 0) :
                while ($row = $qry->fetch_assoc()) :
            ?>
                    <div class="col-auto ticket-item <?= (!$highlight) ? 'highlight-item' : '' ?>" data-id="<?= $row['id'] ?>">
                        <div class="card rounded-0 mx-2">
                            <div class="card-body">
                                <div class="container-fluid item-details">
                                    <h3 class="text-muted text-center item-code"><?= $row['code'] ?></h3>
                                    <h2 class="text-center item-name"><?= $row['name'] ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $highlight = true; ?>
                <?php endwhile; ?>
            <?php else : ?>
            <?php endif; ?>
        </div>
        <hr>
        <div class="d-flex w-100 justify-content-between align-items-end">
            <div class="col-auto">
                <div class="text-light">Total Tickets = <b><?= number_format($qry->num_rows) ?></b></div>
            </div>
            <div class="col-auto">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="exclude_winners" <?= (!isset($_GET['include_winners'])) ? "checked" : "" ?>>
                    <label class="form-check-label text-muted" for="exclude_winners">Excluir Ganadores</label>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <button class="btn btn-lg btn-danger rounded-pill col-lg-4 col-md-6 col-sm-8 col-xs-10" type="button" id="draw">Jugar</button>
        </div>
    </div>
</div>
<?php $conn->close(); ?>

<div class="modal fade rounded-0" id="winnerModal" data-bs-backdrop="static">
    <div class="modal-dialog  modal-lg modal-dialog-centered modal-dialog-scrollable rounded-0">
        <div class="modal-content rounded-0">

            <div class="modal-body rounded-0">
                <div class="container-fluid h-50">
                    <div id="win_template" class="position-relative">
                        <img src="win_bg.jpg" alt="" class="img-fluid">
                        <div id="winner_greet">
                            <h3 id="draw_winner" class="text-center"><b></b></h3>
                            <h1 class="text-center"><b>Felicitaciones|</b></h1>
                        </div>
                        <div id="winner_name">
                            <h3 id="winner_code" class="text-center"><b></b></h3>
                            <h1 id="winner" class="text-center"><b></b></h1>
                        </div>
                    </div>
                </div>
                <div class="text-center my-2">
                    <button type="button" class="btn btm-sm rounded-pill btn-light border" data-bs-dismiss="modal">Guardar Ganador</button>
                </div>
            </div>
        </div>
    </div>
</div>