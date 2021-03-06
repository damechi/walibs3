<?php
/**
* @package waModulo
* @version 3.0
* @author G.Gaiba, F.Monti
* @copyright (c) 2007-2016 {@link http://www.webappls.com WebAppls} Bologna, Italy
* @license http://www.gnu.org/licenses/gpl.html GPLv3
*/

if (!defined('_WA_SELEZIONE'))
{
/**
* @ignore
*/
define('_WA_SELEZIONE',1);

/**
* @ignore
*/
include_once(dirname(__FILE__) . "/controllo.class.php");

//***************************************************************************
//****  classe waSelezione *******************************************************
//***************************************************************************
/**
* waSelezione
*
* classe per la gestione di una select, ossia una lista all'interno
* della quale e' possibile selezionare un solo elemento.
* 
* @package waModulo
* @version 3.0
* @author G.Gaiba, F.Monti
* @copyright (c) 2007-2016 {@link http://www.webappls.com WebAppls} Bologna, Italy
* @license http://www.gnu.org/licenses/gpl.html GPLv3
*/
class waSelezione extends waControllo
	{
	
	/**
	* indica se mostrare una riga vuota in cima alla lista
	*
	* Questa proprieta' e' fondamentale per permettere all'utente la scelta 
	* "nessuna scelta"
	* @var boolean
	*/
	var $rigaVuota		= TRUE;
	
	/**
	* indica se selezionare per default il primo elemento
	*
	* Questa proprieta' ha effetto solo quando {@link $valore} non e' stato
	* esplicitato dall'applicazione e non e' stato valorizzato dal DB.
	* Inoltre, ha senso solo quando {@link $rigaVuota} e' TRUE, altrimenti
	* comunque l'elemento selezionato sarebbe il primo
	* @var boolean
	*/
	var $selezionaPrimo	= false;
	
	/**
	* array dei valori selezionabili.
	*
	* La lista e' un array 
	* associativo in cui la chiave dell'elemento e' l'identificativo della
	* riga (tipicamente un record di una tabella in relazione) e il valore
	* dell'elemento e' la descrizione (text) da porre in corrispondenza della
	* riga.
	*
	* La lista puo' essere creata, in alternativa al passaggio esplicito,
	* a partire da una query da sottoporre al DB: vedi {@link $sql}.
	* @var array
	*/
	var $lista			= array();
	
	/**
	* query SQL per la creazione della lista dei valori selezionabili.
	*
	* Tramite questa query, la classe accedera' al DB e con il risultato della
	* query creera' la lista.
	* Il primo campo sara' la chiave dell'elemento, l'ultimo campo sara'
	* la descrizione dell'elemento.
	* E' possibile definire una query che restituisce piu' di 2 campi; in
	* questo caso, la classe concatenera' tutti i campi, separati da "|" 
	* ad eccezione dell'ultimo (descrizione); questa stringa concatenata
	* diventera' la chiave di ogni elemento. In questo modo e' possibile
	* passare all'applicazione, per ogni riga selezionabile, anche ulteriori
	* informazioni relative alla riga selezionata, oltre all'identificativo
	* univoco.
	* @var string
	*/
	var $sql	= '';
	
	/**
	* @ignore
	* @access protected
	*/
	var $tipo			= 'selezione';
	
	//***************************************************************************
	//***************************************************************************
	//***************************************************************************
	/**
	* @ignore
	*/
	function mostra()
		{
		// se mi viene passata una query, costruisco la lista sulla
		// base della query
		if (!empty($this->sql))
			$this->lista = $this->BuildListFromDBQuery();
			
		$this->xmlOpen();
		$this->xmlAdd("valore", $this->valore);
		$this->xmlAdd("riga_vuota", $this->rigaVuota);
		$this->xmlAdd("seleziona_primo", $this->selezionaPrimo);

		$this->modulo->buffer .= "\t\t\t<lista>\n";
		foreach ($this->lista as $k => $v)
			{
			$v = htmlspecialchars($v);
			$this->modulo->buffer .= "\t\t\t\t<elemento id='$k'>$v</elemento>\n";
			}
		$this->modulo->buffer .= "\t\t\t</lista>\n";
		
		$this->xmlClose();
			
		}

	//***************************************************************************
	/**
	* @access protected
	* @ignore
	*/
	function BuildListFromDBQuery()
		{

		// se mi viene passata una query, costruisco la lista sulla
		// base della query

		if (empty($this->modulo->righeDB))
			// se l'applicazione non ha messo in bind un recordset alla form, non
			// abbiamo le informazioni per connetterci al db
			return (array());

		$rs = new waRigheDB($this->modulo->righeDB->connessioneDB);
		$righe = $rs->caricaDaSql($this->sql);
		if ($rs->nrErrore())
			return (array());

		$list = array();
		foreach ($righe as $riga)
			{
			// costruisco la chiave dell'elemento; la chiave e' composta da tutti i campi
			// ritornati dalla query, separati da "|", ad eccezione dell'ultimo che e' la
			// descrizione da mettere a video. Nella grande maggioranza dei casi avro' solo
			// 2 campi: la chiave di relazione e la descrizione. Gli altri campi, se presenti,
			// servono a ritornare attributi del record selezionato all'applicazione
			$key = $riga->valore(0);
			for ($i = 1; $i < ($rs->nrCampi() - 1); $i++)
				$key .= "|" . $riga->valore($i);
			$list[$key] = $riga->valore($rs->nrCampi() - 1);
			}

		return $list;
		}
		
	//***************************************************************************
	/**
	* ricarica la lista in fase di rpc
	*/
	function rpcRicarica()
		{
		if (!empty($this->sql))
			$this->lista = $this->BuildListFromDBQuery();

		return $this->lista;
		}

		

	}	// fine classe waSelezione

//***************************************************************************
//******* fine della gnola **************************************************
//***************************************************************************
} //  if (!defined('_WA_SELEZIONE'))
?>