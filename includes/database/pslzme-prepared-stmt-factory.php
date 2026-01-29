<?php
final class PslzmePreparedStmtFactory {

    //prevent direct instantiation
    private function __construct() {}

    public static function prepare_create_pslzme_customer_table_stmt() {
        $sqlQuery = "CREATE TABLE IF NOT EXISTS pslzme_kunde (
            KundenID BIGINT AUTO_INCREMENT PRIMARY KEY,
            Name varchar(255) NOT NULL
        )";

        return $sqlQuery;
    }

    public static function prepare_create_pslzme_encryption_info_table_stmt() {
        $sqlQuery = "CREATE TABLE IF NOT EXISTS encrypt_info (
            EncryptionID BIGINT AUTO_INCREMENT PRIMARY KEY,
            EncryptionKey varchar(255) NOT NULL,
            PslzmeKundenID BIGINT NOT NULL,

            CONSTRAINT fk_kunden_id FOREIGN KEY (PslzmeKundenID) REFERENCES pslzme_kunde(KundenID) ON DELETE CASCADE
        )";

        return $sqlQuery;
    }

    public static function prepare_create_pslzme_query_link_table_stmt() {
        $sqlQuery = "CREATE TABLE IF NOT EXISTS query_link (
            QueryID INT AUTO_INCREMENT PRIMARY KEY,
            QueryString VARCHAR(255) NOT NULL,
            CreationTime BIGINT,
            AcceptionTime BIGINT,
            ChangedOn BIGINT,
            Accepted TINYINT(1) NOT NULL,
            Locked TINYINT(1) NOT NULL DEFAULT 0,
            PslzmeKundenID BIGINT NOT NULL,
            EncryptInfoID BIGINT NOT NULL,
        
            CONSTRAINT fk_ql_kunden_id FOREIGN KEY (PslzmeKundenID) REFERENCES pslzme_kunde(KundenID),
            CONSTRAINT fk_ql_encryption_id FOREIGN KEY (EncryptInfoID) REFERENCES encrypt_info(EncryptionID)
        )";

        return $sqlQuery;
    }

    public static function prepare_select_all_pslzme_customer_stmt() {
        $sqlQuery = "SELECT * from pslzme_kunde";

        return $sqlQuery;
    }


    public static function prepare_select_pslzme_customer_by_name_stmt() {
        $sqlQuery = "SELECT KundenID FROM pslzme_kunde WHERE Name = %s";

        return $sqlQuery;
    }

    public static function prepare_select_pslzme_customer_key_stmt() {
        $sqlQuery = "SELECT a.*, b.* FROM pslzme_kunde as a INNER JOIN encrypt_info as b ON a.KundenID=b.PslzmeKundenID WHERE a.KundenID = %d";

        return $sqlQuery;
    }

    public static function prepare_select_pslzme_query_for_customer() {
        $sqlQuery = "SELECT * from query_link WHERE CreationTime = %d AND PslzmeKundenID = %d AND EncryptInfoID = %d";

        return $sqlQuery;
    }

    public static function prepare_select_pslzme_query_stmt() {
        $sqlQuery = "SELECT * FROM query_link WHERE CreationTime = %d AND PslzmeKundenID = %d AND EncryptInfoID = %d";

        return $sqlQuery;
    }

    public static function prepare_insert_pslzme_query_stmt() {
        $sqlQuery = "INSERT INTO query_link (QueryString, CreationTime, AcceptionTime, Accepted, Locked, PslzmeKundenID, EncryptInfoID) VALUES(%s,%d,%d,%d,%d,%d,%d)";

        return $sqlQuery;
    }

    public static function prepare_update_pslzme_query_stmt() {
        $sqlQuery = "UPDATE query_link SET Accepted = %d, Locked = %d, ChangedOn = %d WHERE CreationTime = %d AND PslzmeKundenID = %d AND EncryptInfoID = %d";

        return $sqlQuery;
    } 
}
?>