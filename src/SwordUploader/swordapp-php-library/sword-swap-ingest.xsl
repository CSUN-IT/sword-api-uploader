<?xml version="1.0" encoding="utf-8"?>
<!-- sword-swap-ingest.xsl
 *
 * Copyright (c) 2007, Aberystwyth University
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *  - Redistributions of source code must retain the above
 *    copyright notice, this list of conditions and the
 *    following disclaimer.
 *
 *  - Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in
 *    the documentation and/or other materials provided with the
 *    distribution.
 *
 *  - Neither the name of the Centre for Advanced Software and
 *    Intelligent Systems (CASIS) nor the names of its
 *    contributors may be used to endorse or promote products derived
 *    from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR
 * TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF
 * THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 -->
 
<xsl:stylesheet
        xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
        xmlns:dim="http://www.dspace.org/xmlns/dspace/dim"
        xmlns:epdcx="http://purl.org/eprint/epdcx/2006-11-16/"
        version="1.0">
 
<!-- NOTE: This stylesheet is a work in progress, and does not
     cover all aspects of the SWAP and EPDCX specification/schema.
     It is used principally to demonstrate the SWORD ingest
     process -->
 
<!-- This stylesheet converts incoming DC metadata in a SWAP
     profile into the DSpace Internal Metadata format (DIM) -->
 
                <!-- Catch all.  This template will ensure that nothing
                     other than explicitly what we want to xwalk will be dealt
                     with -->
                <xsl:template match="text()"></xsl:template>
   
    <!-- match the top level descriptionSet element and kick off the
         template matching process -->
    <xsl:template match="/epdcx:descriptionSet">
                <dim:dim>
                                <xsl:apply-templates/>
                </dim:dim>
    </xsl:template>
   
    <!-- general matcher for all "statement" elements -->
    <xsl:template match="/epdcx:descriptionSet/epdcx:description/epdcx:statement">
	
				<!-- custom elements -->
				 
				<!-- advisor element: dc.contributor.advisor (repeatable) -->
	            <xsl:if test="./@epdcx:attributeName='advisor'">
	                            <dim:field mdschema="dc" element="contributor" qualifier="advisor" lang="en_US">
	                                                <xsl:value-of select="epdcx:valueString"/>
	                            </dim:field>
	            </xsl:if>
	
				<!-- committee element: dc.contributor.committeeMember (repeatable)-->
	            <xsl:if test="./@epdcx:attributeName='committeeMember'">
	                            <dim:field mdschema="dc" element="contributor" qualifier="committeeMember" lang="en_US">
	                                                <xsl:value-of select="epdcx:valueString"/>
	                            </dim:field>
	            </xsl:if>
				
				<!-- copyright date element: dc.date.copyright-->
                <xsl:if test="./@epdcx:attributeName='copyrightDate'">
                                <dim:field mdschema="dc" element="date" qualifier="copyright">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>

				<!-- degree element: dc.description.degree-->
                <xsl:if test="./@epdcx:attributeName='degree'">
                                <dim:field mdschema="dc" element="description" qualifier="degree" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>
				
				<!-- description element (bibliographical section): dc.description-->
                <xsl:if test="./@epdcx:attributeName='description'">
                                <dim:field mdschema="dc" element="description" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>

				<!-- extent element: dc.format.extent-->
                <xsl:if test="./@epdcx:attributeName='extent'">
                                <dim:field mdschema="dc" element="format" qualifier="extent" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>

				<!-- rightsURI element: dc.rights.uri-->
                <xsl:if test="./@epdcx:attributeName='rightsURI'">
                                <dim:field mdschema="dc" element="rights" qualifier="uri" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>

				<!-- rightsLicense element: dc.rights.license-->
                <xsl:if test="./@epdcx:attributeName='rightsLicense'">
                                <dim:field mdschema="dc" element="rights" qualifier="license" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>

				<!-- rights element: dc.rights-->
                <xsl:if test="./@epdcx:attributeName='rights'">
                                <dim:field mdschema="dc" element="rights" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>

				<!-- subjectGeneral element (based on major/ plan/ specialization): dc.subject.other-->
                <xsl:if test="./@epdcx:attributeName='subjectGeneral'">
                                <dim:field mdschema="dc" element="subject" qualifier="other" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>

				<!-- subjectKeywords element: dc.subject-->
                <xsl:if test="./@epdcx:attributeName='subjectKeywords'">
                                <dim:field mdschema="dc" element="subject" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>

				<!-- element: dc.contributor.department-->
                <xsl:if test="./@epdcx:attributeName='department'">
                                <dim:field mdschema="dc" element="contributor" qualifier="department" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>
				
				<!-- type element: dc.type-->
                <xsl:if test="./@epdcx:attributeName='type'">
                                <dim:field mdschema="dc" element="type" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>

				<!-- statement of resp element: dc.description.statementofresponsibility-->
                <xsl:if test="./@epdcx:attributeName='statementOfResponsibility'">
                                <dim:field mdschema="dc" element="description" qualifier="statementofresponsibility" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>
				

				<!-- language element: dc.language.iso -->
                <xsl:if test="./@epdcx:attributeName='recordLanguage'">
                                <dim:field mdschema="dc" element="language" qualifier="iso">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>

				<!-- embargoLift element: dc.date.embargoLift -->
                <xsl:if test="./@epdcx:attributeName='embargoLift'">
                                <dim:field mdschema="dc" element="date" qualifier="embargoLift" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>

				<!-- embargoTerms element: dc.description.embargoTerms -->
                <xsl:if test="./@epdcx:attributeName='embargoTerms'">
                                <dim:field mdschema="dc" element="description" qualifier="embargoTerms" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>

                <!-- title element: dc.title -->
                <xsl:if test="./@epdcx:propertyURI='http://purl.org/dc/elements/1.1/title'">
                                <dim:field mdschema="dc" element="title" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>

				<!-- publisher element: dc.publisher -->
                <xsl:if test="./@epdcx:propertyURI='http://purl.org/dc/elements/1.1/publisher'">
                                <dim:field mdschema="dc" element="publisher" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>
               
                <!-- abstract element: dc.description.abstract -->
                <xsl:if test="./@epdcx:propertyURI='http://purl.org/dc/terms/abstract'">
                                <dim:field mdschema="dc" element="description" qualifier="abstract" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>
               
                <!-- creator element: dc.contributor.author -->
                <xsl:if test="./@epdcx:propertyURI='http://purl.org/dc/elements/1.1/creator'">
                                <dim:field mdschema="dc" element="contributor" qualifier="author" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>
               
                <!-- identifier element: dc.identifier.* -->
                <xsl:if test="./@epdcx:propertyURI='http://purl.org/dc/elements/1.1/identifier'">
                                <xsl:element name="dim:field">
                                                <xsl:attribute name="mdschema">dc</xsl:attribute>
                                                <xsl:attribute name="element">identifier</xsl:attribute>
                                                <xsl:if test="epdcx:valueString[@epdcx:sesURI='http://purl.org/dc/terms/URI']">
                                                                <xsl:attribute name="qualifier">uri</xsl:attribute>
                                                </xsl:if>
                                                <xsl:value-of select="epdcx:valueString"/>
                                </xsl:element>
                </xsl:if>
               
                <!-- date available element: dc.date.issued -->
                <xsl:if test="./@epdcx:propertyURI='http://purl.org/dc/terms/available'">
                                <dim:field mdschema="dc" element="date" qualifier="issued">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>
               
                <!-- publication status element: dc.description.version -->
                <xsl:if test="./@epdcx:propertyURI='http://purl.org/eprint/terms/status' and ./@epdcx:vesURI='http://purl.org/eprint/terms/Status'">
                                <xsl:if test="./@epdcx:valueURI='http://purl.org/eprint/status/PeerReviewed'">
                                                <dim:field mdschema="dc" element="description" qualifier="version" lang="en_US">
                                                                Peer Reviewed
                                                </dim:field>
                                </xsl:if>
                </xsl:if>
               
                <!-- copyright holder element: dc.rights.holder -->
                <xsl:if test="./@epdcx:propertyURI='http://purl.org/eprint/terms/copyrightHolder'">
                                <dim:field mdschema="dc" element="rights" qualifier="holder" lang="en_US">
                                                <xsl:value-of select="epdcx:valueString"/>
                                </dim:field>
                </xsl:if>
 
        <!-- bibliographic citation element: dc.identifier.citation -->
        <xsl:if test="./@epdcx:propertyURI='http://purl.org/eprint/terms/bibliographicCitation'">
            <dim:field mdschema="dc" element="identifier" qualifier="citation" lang="en_US">
                <xsl:value-of select="epdcx:valueString"/>
            </dim:field>
        </xsl:if>
               
    </xsl:template>
   
</xsl:stylesheet>