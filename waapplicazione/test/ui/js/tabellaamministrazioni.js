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
			
	//-------------------------------------------------------------------------
	link_watabella_EMAIL: function (id)
		{
		document.location.href = "mailto:" + this.tabella.righe[id].campi.EMAIL +
									"?subject=vattela a pescarla" + 
									"&body=sei andato a pescare, ieri? ciao, me.";
		}
		
	}
);

//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------
document.wapagina = new wapagina();



