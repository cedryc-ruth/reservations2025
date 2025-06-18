<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:atom="http://www.w3.org/2005/Atom">

  <xsl:output method="html" encoding="UTF-8"/>

  <xsl:template match="/">
    <html lang="fr">
      <head>
        <meta charset="UTF-8"/>
        <title><xsl:value-of select="/atom:feed/atom:title"/></title>
        <style>
          body { font-family: sans-serif; padding: 2em; background: #f9f9f9; color: #222; }
          h1 { font-size: 2em; border-bottom: 2px solid #ccc; }
          .entry { margin-bottom: 2em; border-bottom: 1px solid #ddd; padding-bottom: 1em; }
          .entry-title { font-size: 1.2em; font-weight: bold; color: #005599; }
          .entry-summary { margin-top: 0.5em; color: #333; }
          .entry-date { font-size: 0.9em; color: #999; }
        </style>
      </head>
      <body>
        <h1><xsl:value-of select="/atom:feed/atom:title"/></h1>
        <xsl:for-each select="/atom:feed/atom:entry">
          <div class="entry">
            <div class="entry-title">
              <a href="{atom:link/@href}">
                <xsl:value-of select="atom:title"/>
              </a>
            </div>
            <div class="entry-summary">
              <xsl:value-of select="atom:summary"/>
            </div>
            <div class="entry-date">
              <xsl:value-of select="atom:updated"/>
            </div>
          </div>
        </xsl:for-each>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
