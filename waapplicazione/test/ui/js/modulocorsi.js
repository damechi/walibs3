//*****************************************************************************
//*****************************************************************************
//*****************************************************************************
// classe wapagina
var wapagina = new Class
(
	{
	//-------------------------------------------------------------------------
	// extends
	Extends: app_prova,

	//-------------------------------------------------------------------------
	// proprieta'

	//-------------------------------------------------------------------------
	//initialization  
	// non serve: richiama quella del parent			
	
	//-------------------------------------------------------------------------
	evento_onchange_wamodulo_id_organismo: function (event)
		{
		alert("EHI SON QUA");
		}
		
	}
);

//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
document.wapagina = new wapagina(document.wamodulo ? document.wamodulo.wamodulo : null);



