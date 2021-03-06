<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:import href="template_comuni.xsl"/>

	<xsl:output method="xml" omit-xml-declaration="yes" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" indent="yes" /> 

	<!-- ********************************************************************** -->
	<!--  ************* template della pagina ********************************* -->
	<!-- ********************************************************************** -->
	<xsl:template match="wadocumentazione">
		<html xmlns="http://www.w3.org/1999/xhtml">

			<xsl:call-template name="head">
				<xsl:with-param name="titolo" select="concat('Tabella - ', tabella/titolo)" />
			</xsl:call-template>

			<body >

				<xsl:call-template name="barra_navigazione" />

				<xsl:call-template name="titolo">
					<xsl:with-param name="titolo" select="'Tabella'" />
					<xsl:with-param name="titolo2" select="tabella/titolo" />
				</xsl:call-template>

				<h2>Appartiene a</h2>
				<table>
					<tr>
						<th>Sezione</th>
						<th>Pagina</th>
					</tr>
					<tr>
						<td>
							<a href='sezione.{sezione/idSezione}.html'>
								<xsl:value-of select="sezione/nome" />
							</a>
						</td>
						<td>
							<a href='pagina.{pagina/idPagina}.html'>
								<xsl:value-of select="pagina/titolo" />
							</a>
						</td>
					</tr>
				</table>

				<xsl:if test="tabella/descrizione != ''">
					<p />
					<table>
						<tr>
							<th>Descrizione</th>
							<td>
								<xsl:value-of select="tabella/descrizione" disable-output-escaping="yes"/>
							</td>
						</tr>
					</table>
						
				</xsl:if>
				
				<h2>Colonne</h2>
				<table>
					<tr>
						<th>Intestazione</th>
						<th>Campo</th>
						<th style="text-align: center">Visibile</th>
						<th style="text-align: center">Ordinabile</th>
						<th style="text-align: center">Filtrabile</th>
						<th style="text-align: center">Totalizza</th>
						<th>Alias di</th>
						<th>Note</th>
					</tr>
				
					<xsl:for-each select="colonne/item">
						<tr>
							<td>
								<xsl:value-of select="etichetta" />
							</td>
							<td>
								<xsl:choose>
									<xsl:when test="idCampo > 0">
										<a href="tabella_db.{idTabellaDB}.html#{idCampo}">
											<xsl:value-of select="nome" />
										</a>
									</xsl:when>
									<xsl:otherwise>
										<xsl:value-of select="nome" />
									</xsl:otherwise>
								</xsl:choose>						
							</td>
							<td style="text-align: center">
								<xsl:choose>
									<xsl:when test="mostra > 0">si </xsl:when>
									<xsl:otherwise>no</xsl:otherwise>
								</xsl:choose>						
							</td>
							<td style="text-align: center">
								<xsl:choose>
									<xsl:when test="ordina > 0">si </xsl:when>
									<xsl:otherwise>no</xsl:otherwise>
								</xsl:choose>						
							</td>
							<td style="text-align: center">
								<xsl:choose>
									<xsl:when test="filtra > 0">si </xsl:when>
									<xsl:otherwise>no</xsl:otherwise>
								</xsl:choose>						
							</td>
							<td style="text-align: center">
								<xsl:choose>
									<xsl:when test="totalizza > 0">si</xsl:when>
									<xsl:otherwise>no</xsl:otherwise>
								</xsl:choose>						
							</td>
							<td>
								<xsl:value-of select="aliasDi" />
							</td>
							<td>
								<xsl:value-of select="descrizione" disable-output-escaping="yes"/>
							</td>
						</tr>
					</xsl:for-each>
				</table>

				
				<h2>Azioni su pagina</h2>
				<table>
					<tr>
						<th>Azione</th>
						<th>Note</th>
					</tr>
					<xsl:for-each select="azioni/pagina/item">
						<tr>
							<td>
								<xsl:value-of select="etichetta" />
							</td>
							<td>
								<xsl:value-of select="descrizione" disable-output-escaping="yes"/>
							</td>
						</tr>
					</xsl:for-each>
				</table>

				<h2>Azioni su record</h2>
				<table>
					<tr>
						<th>Azione</th>
						<th style="text-align: center">Condizionata</th>
						<th>Note</th>
					</tr>
					<xsl:for-each select="azioni/record/item">
						<tr>
							<td>
								<xsl:value-of select="etichetta" />
							</td>
							<td style="text-align: center">
								<xsl:choose>
									<xsl:when test="condizionata > 0">si</xsl:when>
									<xsl:otherwise>no</xsl:otherwise>
								</xsl:choose>						
							</td>
							<td>
								<xsl:value-of select="descrizione" disable-output-escaping="yes"/>
							</td>
						</tr>
					</xsl:for-each>
				</table>


				<xsl:call-template name="barra_navigazione" >
					<xsl:with-param name="fine_pagina" select="'1'" />
				</xsl:call-template>
			
			</body>
		</html>
	</xsl:template>


	<!-- ********************************************************************** -->
	<!-- ********************************************************************** -->
	<!-- ********************************************************************** -->
</xsl:stylesheet>