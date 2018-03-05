<?php
namespace Authentication\Model;

use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter;
use Zend\Db\Adapter\Adapter as DbAdapter;

/**
 * Authentification Service
 */
class AuthentificationAdapter extends CallbackCheckAdapter
{
    /**
     * @const string
     */
    const TABLE_NAME = 'users';

    /**
     * @const string
     */
    const IDENTITY_COLUMN = 'username';

    /**
     * @const string
     */
    const CREDENTIAL_COLUMN = 'password';

    /**
     * Constructor
     *
     * @param DbAdapter $zendDb
     * @param string    $tableName                    Optional
     * @param string    $identityColumn               Optional
     * @param string    $credentialColumn             Optional
     * @param callable  $credentialValidationCallback Optional
     */
    public function __construct(
        DbAdapter $zendDb,
        $tableName = null,
        $identityColumn = null,
        $credentialColumn = null,
        $credentialValidationCallback = null
    ) {
        parent::__construct(
            $zendDb,
            $tableName,
            $identityColumn,
            $credentialColumn,
            $credentialValidationCallback
        );
    }
}
