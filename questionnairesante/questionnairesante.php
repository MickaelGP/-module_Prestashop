<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class QuestionnaireSante extends Module
{
    public function __construct()
    {
        $this->name = 'questionnairesante';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Mickael GP';

        parent::__construct();

        $this->displayName = $this->l('Questionnaire de Santé');
        $this->description = $this->l('Ajoute un formulaire "Questionnaire de santé" dans le tunnel de commande.');
    }

    public function install()
    {
        if (!parent::install() ||
           !$this->createTable() ||
            !$this->registerHook('displayBeforeCarrier') ||
            !$this->registerHook('actionCustomerAccountAdd')
        ) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall() || !$this->dropTable()) {
            return false;
        }

        return true;
    }

    public function hookDisplayBeforeCarrier()
    {
        return $this->display(__FILE__, 'views/templates/hook/questionnaire.tpl');
    }

    public function hookActionCustomerAccountAdd($params)
    {
        $newCustomer = $params['newCustomer'];
        $customerId = $newCustomer->id;

        $question1Response = Tools::getValue('age');
        $question2Response = Tools::getValue('allergies');
        $question3Response = Tools::getValue('poids');
        $question4Response = Tools::getValue('taille');

        
        $data = array(
            'id_customer' => (int)$customerId,
            'age' => (int)$question1Response,
            'allergies' => pSQL($question2Response),
            'poids' => (int)$question3Response,
            'taille' => pSQL($question4Response),
            
        );

        Db::getInstance()->insert('questionnaire_medical', $data);
    }

    private function createTable()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'questionnaire_medical` (
            `id_questionnaire` INT NOT NULL AUTO_INCREMENT,
            `id_customer` INT NOT NULL,
            `age` INT NOT NULL,
            `allergies` VARCHAR(255) NOT NULL,
            `poids` INT NOT NULL,
            `taille` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`id_questionnaire`)
        ) ENGINE = InnoDB DEFAULT CHARSET=utf8;';
        
        $db = Db::getInstance();

        if ($db->execute($sql)) {
            error_log('Table questionnaire_medical créée avec succès.');
            return true;
        } else {
            error_log('Échec de la création de la table questionnaire_medical: ' . $db->getMsgError());
            return false;
        }
    }

    private function dropTable()
    {
        $sql = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'questionnaire_medical`';

        return Db::getInstance()->execute($sql);
    }
}