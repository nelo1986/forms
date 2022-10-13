<?php

$referer = $_SERVER['HTTP_REFERER'];
$referer_parse = parse_url($referer);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        header("Location: https://academymembers.pue.es");
        exit();
    }
    if($referer_parse['host'] == "academymembers.pue.es") {
         // Page content will display
    }
    else {
        header("Location: https://pue.es");
        exit();
    }


$config = array(
        'url'=>'http://localhost/api/http.php/tickets.json',
        'key'=>'D170851F455E9A331339D95875A9A84B'
        );


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$random_zip = generateRandomString() . '.zip';
$name_full_zip = '/tmp/' . $random_zip;




// Si el usuario existe dos ficheros o más, lo comprimimos en un zip.
// Para ello inicializamos el fichero zip.
// Recorremos el array $_FILES y vamos añadiendo los ficheros al zip.
// Finalmente lo cerramos y lo añadimos al $array_files


$name = $_POST['name'];
$institution_name = $_POST['institution_name'];
$phone = $_POST['phone'];
$contract_number = $_POST['contract_number'];
$product = $_POST['product'];
$message = $_POST['message'];
$subject = $_POST['subject'];
$useremail = $_POST['useremail'];


$data = array(

    'Nombre_y_Apellidos'      =>      $name,
    'institution_name'       =>      $institution_name,
    'phone_contact'    =>      $phone,
    'contract_number'      =>      $contract_number,
    'product'                =>      $product,
    'name'        =>      $name,
    'email'     =>      $useremail,
    'subject'   =>      $subject,
    'message'   =>      $message,
    'ip'        =>      '127.0.0.1',
    'topicId'   =>      '26',//cisco Academy
    );









if (count($_FILES['uploadfiles']['name']) == 1 && $_FILES['uploadfiles']['error'][0] == 4 )
{

    $data['attachments'] = array();


} else {


if (count($_FILES['uploadfiles']['name']) >= 2) {

$zip = new ZipArchive;

if ($zip->open($name_full_zip, ZipArchive::CREATE) === TRUE)
{

    for ($i = 0; $i < count($_FILES['uploadfiles']['name']); $i++) {

        $base_name_file = $_FILES['uploadfiles']['name'][$i];
        $temporal_dir = $_FILES['uploadfiles']['tmp_name'][$i];

        $zip->addFile($temporal_dir);
            // renombramos el nombre temporal por el nombre real del fichero
        $zip->renameName($temporal_dir, $base_name_file);

    }
    $zip->close();

    $array_files[$random_zip] = 'data:' . mime_content_type($name_full_zip) . ';base64,' . base64_encode(file_get_contents($name_full_zip));
}
} else {

    $base_name_file = $_FILES['uploadfiles']['name'][0];
    $mime_type = $_FILES['uploadfiles']['type'][0];
    $temporal_dir = $_FILES['uploadfiles']['tmp_name'][0];

    $array_files[$base_name_file] = 'data:' . $mime_type . ';base64,' . base64_encode(file_get_contents($temporal_dir));

}


$data['attachments'] = array($array_files);


}


#pre-checks
function_exists('curl_version') or die('CURL support required');
function_exists('json_encode') or die('JSON support required');

#set timeout
set_time_limit(30);



#curl post
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $config['url']);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_USERAGENT, 'osTicket API Client v1.7');
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Expect:', 'X-API-Key: '.$config['key']));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);



$result=curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);


$ticket_id = (int) $result;


?>

    <!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



<?php if ($code != 201){

    if (empty($_POST) && empty($_FILES)){
        #close();
        echo "<script>window.close();</script>";
    }
    $ticket = "Error al enviar la solicitud. Por favor, póngase en contacto con soporte.academy@pue.es indicando su solicitud y el siguiente error: <br><strong>'".$result.$tmail."'</strong>";
    $title = "Error al enviar la solicitud";


        }
    else {
        $ticket = "Se ha generado un ticket con el código " .$result."</br> Puede consultar el estado de su solicitud a través del enlace que habrá recibido en el siguiente correo: ".$useremail;
        $title = "Solicitud enviada";
    }



?>


        <script type="text/javascript">
            $(window).on('load', function() {
                $('#TicketModal').modal('show');
            });
        </script>

    </head>

    <body>
        <div class="modal fade" id="TicketModal" tabindex="-1" role="dialog" aria-labelledby="TicketModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="TicketModal"><?php echo $title; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo $ticket; ?>


                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.history.go(-1); return false;">Aceptar</button> -->
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.href = document.referrer; return false;">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
                }
            </script>
    </body>
</html>
