<?php
$error = '';
if (isset($_POST['note']) && isset($_POST['filename'])) {
    $note = $_POST['note'];
    $filename = $_POST['filename'];
    if (!empty($filename)) {
        if (!isset($_POST['original_filename']) || $_POST['original_filename'] !== $filename . '.txt') {
            if (file_exists($filename . '.txt')) {
                $error = 'Ya existe una nota con ese nombre. Por favor elige otro nombre.';
            } else {
                if (isset($_POST['original_filename'])) {
                    rename($_POST['original_filename'], $filename . '.txt');
                }
                file_put_contents($filename . '.txt', $note);
            }
        } else {
            file_put_contents($filename . '.txt', $note);
        }
    } else {
        $error = 'Debes especificar un nombre para la nota.';
    }
}

if (isset($_GET['delete'])) {
    if (file_exists($_GET['delete'])) {
        unlink($_GET['delete']);
    }
}

$notes = glob('*.txt');

$selected_note = '';
$selected_filename = '';
if (isset($_GET['edit'])) {
    if (file_exists($_GET['edit'])) {
        $selected_note = file_get_contents($_GET['edit']);
        $selected_filename = basename($_GET['edit'], '.txt');
    }
}
?>

<?php if (!empty($error)): ?>
<p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notepad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="shortcut icon" href="img/note.ico" type="image/x-icon">


</head>
<body > 
    
<div class="b-example-divider"></div>
<div class="b-example-divider"></div>
    
<div class="col-auto p-5 " >


  <div class=" text-secondary container my-5">
    <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">
      <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">      
            <h1>Notepad</h1>
            <br>
        <form method="post">
            <input type="hidden" name="original_filename" value="<?php echo htmlspecialchars($selected_filename); ?>.txt">
            <label for="filename">Nombre del archivo:</label> <br>
            <input type="text" id="filename" name="filename" value="<?php echo htmlspecialchars($selected_filename); ?>"><br><br>
            <label for="note">Nota:</label><br>
            <textarea id="note" name="note"><?php echo htmlspecialchars($selected_note); ?></textarea><br><br>
            <input type="submit" value="Guardar" class="btn btn-success">
        </form>
        <br><br>
        <h2>Notas guardadas</h2>
        <ul>
        <?php foreach ($notes as $note): ?>
            <li>
                <a href="<?php echo htmlspecialchars($note); ?>"><?php echo htmlspecialchars(basename($note, '.txt')); ?></a> |
                <a href="?edit=<?php echo urlencode($note); ?>">Editar</a> |
                <a href="?delete=<?php echo urlencode($note); ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar esta nota?');">Eliminar</a>
            </li>
        <?php endforeach; ?>
        </ul>
        </div>

        </div>
      </div>
      <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">
          <img class="rounded-lg-3" src="bootstrap-docs.png" alt="" width="720">
      </div>
    </div>
  </div>

<div class="b-example-divider"></div>
<div class="b-example-divider"></div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    
</body>
</html>
