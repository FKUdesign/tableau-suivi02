<?php
// config/database.php - Configuration de la base de données
class Database {
    private $host = 'localhost';
    private $db_name = 'suivi_projet';
    private $username = 'root'; // Changez selon votre configuration
    private $password = '';     // Changez selon votre configuration
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch(PDOException $exception) {
            echo "Erreur de connexion: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// classes/Projet.php - Classe pour gérer les projets
class Projet {
    private $conn;
    private $table_name = "projets";

    public $id;
    public $etat;
    public $sorti_dossier_be;
    public $nom;
    public $ville;
    public $type_projet;
    public $ral;
    public $soudure;
    public $tole;
    public $cintrage;
    public $preparation_lasurage;
    public $debit;
    public $usinage;
    public $divers;
    public $vitrage;
    public $isotoit;
    public $commande_composite;
    public $spot;
    public $client_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer tous les projets
    public function read() {
        $query = "SELECT p.*, c.nom as client_nom 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN clients c ON p.client_id = c.id 
                  ORDER BY p.sorti_dossier_be DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Créer un nouveau projet
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET etat=:etat, sorti_dossier_be=:sorti_dossier_be, nom=:nom, 
                      ville=:ville, type_projet=:type_projet, ral=:ral, 
                      soudure=:soudure, tole=:tole, cintrage=:cintrage,
                      preparation_lasurage=:preparation_lasurage, debit=:debit,
                      usinage=:usinage, divers=:divers, vitrage=:vitrage,
                      isotoit=:isotoit, commande_composite=:commande_composite,
                      spot=:spot, client_id=:client_id";

        $stmt = $this->conn->prepare($query);

        // Nettoyer les données
        $this->etat = htmlspecialchars(strip_tags($this->etat));
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->ville = htmlspecialchars(strip_tags($this->ville));

        // Bind des paramètres
        $stmt->bindParam(":etat", $this->etat);
        $stmt->bindParam(":sorti_dossier_be", $this->sorti_dossier_be);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":ville", $this->ville);
        $stmt->bindParam(":type_projet", $this->type_projet);
        $stmt->bindParam(":ral", $this->ral);
        $stmt->bindParam(":soudure", $this->soudure);
        $stmt->bindParam(":tole", $this->tole);
        $stmt->bindParam(":cintrage", $this->cintrage);
        $stmt->bindParam(":preparation_lasurage", $this->preparation_lasurage);
        $stmt->bindParam(":debit", $this->debit);
        $stmt->bindParam(":usinage", $this->usinage);
        $stmt->bindParam(":divers", $this->divers);
        $stmt->bindParam(":vitrage", $this->vitrage);
        $stmt->bindParam(":isotoit", $this->isotoit);
        $stmt->bindParam(":commande_composite", $this->commande_composite);
        $stmt->bindParam(":spot", $this->spot);
        $stmt->bindParam(":client_id", $this->client_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Mettre à jour un projet
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET etat=:etat, sorti_dossier_be=:sorti_dossier_be, nom=:nom,
                      ville=:ville, type_projet=:type_projet, ral=:ral,
                      soudure=:soudure, tole=:tole, cintrage=:cintrage,
                      preparation_lasurage=:preparation_lasurage, debit=:debit,
                      usinage=:usinage, divers=:divers, vitrage=:vitrage,
                      isotoit=:isotoit, commande_composite=:commande_composite,
                      spot=:spot
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Nettoyer les données
        $this->etat = htmlspecialchars(strip_tags($this->etat));
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->ville = htmlspecialchars(strip_tags($this->ville));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind des paramètres
        $stmt->bindParam(":etat", $this->etat);
        $stmt->bindParam(":sorti_dossier_be", $this->sorti_dossier_be);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":ville", $this->ville);
        $stmt->bindParam(":type_projet", $this->type_projet);
        $stmt->bindParam(":ral", $this->ral);
        $stmt->bindParam(":soudure", $this->soudure);
        $stmt->bindParam(":tole", $this->tole);
        $stmt->bindParam(":cintrage", $this->cintrage);
        $stmt->bindParam(":preparation_lasurage", $this->preparation_lasurage);
        $stmt->bindParam(":debit", $this->debit);
        $stmt->bindParam(":usinage", $this->usinage);
        $stmt->bindParam(":divers", $this->divers);
        $stmt->bindParam(":vitrage", $this->vitrage);
        $stmt->bindParam(":isotoit", $this->isotoit);
        $stmt->bindParam(":commande_composite", $this->commande_composite);
        $stmt->bindParam(":spot", $this->spot);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Supprimer un projet
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Récupérer un projet par ID
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->etat = $row['etat'];
            $this->sorti_dossier_be = $row['sorti_dossier_be'];
            $this->nom = $row['nom'];
            $this->ville = $row['ville'];
            $this->type_projet = $row['type_projet'];
            $this->ral = $row['ral'];
            $this->soudure = $row['soudure'];
            $this->tole = $row['tole'];
            $this->cintrage = $row['cintrage'];
            $this->preparation_lasurage = $row['preparation_lasurage'];
            $this->debit = $row['debit'];
            $this->usinage = $row['usinage'];
            $this->divers = $row['divers'];
            $this->vitrage = $row['vitrage'];
            $this->isotoit = $row['isotoit'];
            $this->commande_composite = $row['commande_composite'];
            $this->spot = $row['spot'];
            $this->client_id = $row['client_id'];
        }
    }

    // Statistiques
    public function getStats() {
        $query = "SELECT etat, COUNT(*) as count FROM " . $this->table_name . " GROUP BY etat";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

// api/projets.php - API REST pour les projets
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../classes/Projet.php';

$database = new Database();
$db = $database->getConnection();
$projet = new Projet($db);

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        if(isset($_GET['id'])) {
            // Récupérer un projet spécifique
            $projet->id = $_GET['id'];
            $projet->readOne();
            
            $projet_arr = array(
                "id" => $projet->id,
                "etat" => $projet->etat,
                "sorti_dossier_be" => $projet->sorti_dossier_be,
                "nom" => $projet->nom,
                "ville" => $projet->ville,
                "type_projet" => $projet->type_projet,
                "ral" => $projet->ral,
                "soudure" => $projet->soudure,
                "tole" => $projet->tole,
                "cintrage" => $projet->cintrage,
                "preparation_lasurage" => $projet->preparation_lasurage,
                "debit" => $projet->debit,
                "usinage" => $projet->usinage,
                "divers" => $projet->divers,
                "vitrage" => $projet->vitrage,
                "isotoit" => $projet->isotoit,
                "commande_composite" => $projet->commande_composite,
                "spot" => $projet->spot,
                "client_id" => $projet->client_id
            );
            
            http_response_code(200);
            echo json_encode($projet_arr);
        } else {
            // Récupérer tous les projets
            $stmt = $projet->read();
            $num = $stmt->rowCount();
            
            if($num > 0) {
                $projets_arr = array();
                $projets_arr["records"] = array();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $projet_item = array(
                        "id" => $id,
                        "etat" => $etat,
                        "sorti_dossier_be" => $sorti_dossier_be,
                        "nom" => $nom,
                        "ville" => $ville,
                        "type_projet" => $type_projet,
                        "ral" => $ral,
                        "soudure" => $soudure,
                        "tole" => $tole,
                        "cintrage" => $cintrage,
                        "preparation_lasurage" => $preparation_lasurage,
                        "debit" => $debit,
                        "usinage" => $usinage,
                        "divers" => $divers,
                        "vitrage" => $vitrage,
                        "isotoit" => $isotoit,
                        "commande_composite" => $commande_composite,
                        "spot" => $spot,
                        "client_nom" => $client_nom
                    );
                    array_push($projets_arr["records"], $projet_item);
                }
                
                http_response_code(200);
                echo json_encode($projets_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Aucun projet trouvé."));
            }
        }
        break;
        
    case 'POST':
        // Créer un nouveau projet
        $data = json_decode(file_get_contents("php://input"));
        
        if(!empty($data->nom) && !empty($data->ville) && !empty($data->etat)) {
            $projet->etat = $data->etat;
            $projet->sorti_dossier_be = $data->sorti_dossier_be ?? null;
            $projet->nom = $data->nom;
            $projet->ville = $data->ville;
            $projet->type_projet = $data->type_projet;
            $projet->ral = $data->ral ?? '';
            $projet->soudure = $data->soudure ?? '';
            $projet->tole = $data->tole ?? '';
            $projet->cintrage = $data->cintrage ?? '';
            $projet->preparation_lasurage = $data->preparation_lasurage ?? '';
            $projet->debit = $data->debit ?? '';
            $projet->usinage = $data->usinage ?? '';
            $projet->divers = $data->divers ?? '';
            $projet->vitrage = $data->vitrage ?? '';
            $projet->isotoit = $data->isotoit ?? '';
            $projet->commande_composite = $data->commande_composite ?? '';
            $projet->spot = $data->spot ?? '';
            $projet->client_id = $data->client_id ?? null;
            
            if($projet->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Projet créé avec succès."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Impossible de créer le projet."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Impossible de créer le projet. Données incomplètes."));
        }
        break;
        
    case 'PUT':
        // Mettre à jour un projet
        $data = json_decode(file_get_contents("php://input"));
        
        $projet->id = $data->id;
        $projet->etat = $data->etat;
        $projet->sorti_dossier_be = $data->sorti_dossier_be;
        $projet->nom = $data->nom;
        $projet->ville = $data->ville;
        $projet->type_projet = $data->type_projet;
        $projet->ral = $data->ral;
        $projet->soudure = $data->soudure;
        $projet->tole = $data->tole;
        $projet->cintrage = $data->cintrage;
        $projet->preparation_lasurage = $data->preparation_lasurage;
        $projet->debit = $data->debit;
        $projet->usinage = $data->usinage;
        $projet->divers = $data->divers;
        $projet->vitrage = $data->vitrage;
        $projet->isotoit = $data->isotoit;
        $projet->commande_composite = $data->commande_composite;
        $projet->spot = $data->spot;
        
        if($projet->update()) {
            http_response_code(200);
            echo json_encode(array("message" => "Projet mis à jour avec succès."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Impossible de mettre à jour le projet."));
        }
        break;
        
    case 'DELETE':
        // Supprimer un projet
        $data = json_decode(file_get_contents("php://input"));
        $projet->id = $data->id;
        
        if($projet->delete()) {
            http_response_code(200);
            echo json_encode(array("message" => "Projet supprimé avec succès."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Impossible de supprimer le projet."));
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Méthode non autorisée."));
        break;
}

// api/stats.php - API pour les statistiques
if($_SERVER['REQUEST_URI'] === '/api/stats.php') {
    $stmt = $projet->getStats();
    $stats = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $stats[$row['etat']] = $row['count'];
    }
    
    http_response_code(200);
    echo json_encode($stats);
}
?>