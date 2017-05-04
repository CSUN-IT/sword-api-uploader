<?php

namespace CSUNMetaLab\SwordUploader\Packagers;

use PackagerMetsSwap;
use CSUNMetaLab\SwordUploader\Contracts\PackagerContract;

use ZipArchive;

use Exception;
use CSUNMetaLab\SwordUploader\Exceptions\CannotCreatePackageDependencyException;
use CSUNMetaLab\SwordUploader\Exceptions\CannotCreatePackageException;
use CSUNMetaLab\SwordUploader\Exceptions\CannotWritePackageMetadataException;

class ThesisPackager implements PackagerContract {
	/************ File Variables ************/

	// The location of the files
	public $finalRootIn;
	public $suppRootIn;

	// The location to write the package out to
	public $zipRootOut;

	// The location to write the mets files out to
	public $metsRootOut;

	// The filename to save the package as
	public $zipFileOut;

	// The name of the metadata file
	public $metadataFilename;

	// Multi-dimensional array of file information 
	// Each element contains ("basename"=>, "originalName"=>, "mimeType"=>, "fileType"=>)
	public $files;

	/*********** Metadata Variables *********/

	public $issueDate;
	public $copyrightDate;
	public $submittedDate;
	public $language;
	public $publisher;
	public $rights;
	public $rightsURI;
	public $rightsLicense;

	public $advisor;
	public $committee;
	public $degree;
	public $description;
	public $abstract;
	public $statementOfResponsibility;
	public $extent;
	public $subjectKeywords;
	public $title;
	public $type; //thesis, dissertation, etc.
	public $embargoLift; //date 
	public $embargoTerms; //text description -- ie '2 years'
	public $authors;
	public $subjectGeneral; //degree subject -- ie 'Dissertations, Academic--University--Computer Science'
	public $department;

	public $identifier;
	public $department;
	public $copyrightHolder;
	public $custodian;
	public $citation;
	public $provenances;
	public $statusstatement;

	/**
	 * Constructs a new ThesisPackager object.
	 *
	 * @param string $filename The filename that will be used for output
	 */
	public function __construct($filename){
		//Set passed file paths
		$this->finalRootIn = config('sword.files.roots.input.theses.document');
		$this->suppRootIn = config('sword.files.roots.input.theses.supplemental');
		$this->zipRootOut = config('sword.files.roots.output.theses.package');
		$this->zipFileOut = $filename;
		$this->metsRootOut = config('sword.files.roots.output.theses.mets');
		//Build file arrays
		$this->files = array();
		$this->mimetypes = array();
		//Build metadata arrays
		$this->authors = array();
		$this->subjectKeywords = array();
		$this->provenances = array();
		$this->committee = array();
	}

	/******************* Setters *********************/

	function setMetadataFilename($_metadataFilename){
		$this->metadataFilename = $_metadataFilename;
	}

	function addFile($_fileArray){
		$this->files[]=$_fileArray;
		}

	function setIssueDate($_issueDate) {
		$this->issueDate = $_issueDate;
		}

	function setCopyrightDate($_copyrightDate){
		$this->copyrightDate = $_copyrightDate;
	}

	function setSubmittedDate($_submittedDate) {
		$this->submittedDate = $_submittedDate;
	}

	function setLanguage($_language) {
		$this->language = $this->clean($_language);
		}

	function setPublisher($_publisher){
		$this->publisher = $this->clean($_publisher);
	}

	function setRights($_rights) {
		$this->rights = $this->clean($_rights);
		}

	function setRightsURI($_rightsURI) {
		$this->rightsURI = $this->clean($_rightsURI);
		}

	function setRightsLicense($_rightsLicense) {
		$this->rightsLicense = $this->clean($_rightsLicense);
		}

	function setAdvisor($_advisor){
		$this->advisor = $this->clean($_advisor);
	}

	function addCommittee($_committee) {
		array_push($this->committee, $this->clean($_committee));
		}

	function setDegree($_degree){
		$this->degree = $this->clean($_degree);
	}

	function setDescription($_description){
		$this->description = $this->clean($_description);
	}

	function setAbstract($_abstract) {
		$this->abstract = $this->clean($_abstract);
		}

	function setStatementOfResponsibility($_statementOfResponsibility){
		$this->statementOfResponsibility = $this->clean($_statementOfResponsibility);
	}

	function setExtent($_extent){
		$this->extent = $this->clean($_extent);
	}

	function addSubjectKeyword($_subjectKeyword) {
		array_push($this->subjectKeywords, $this->clean($_subjectKeyword));
		}

	function setTitle($_title) {
		$this->title = $this->clean($_title);
		}

		function setType($_type) {
			$this->type = $this->clean($_type);
		}

		function setEmbargoLift($_embargoLift){
			$this->embargoLift = $_embargoLift;
	}

	function setEmbargoTerms($_embargoTerms){
		$this->embargoTerms = $this->clean($_embargoTerms);
	}

		function addAuthor($_author) {
			array_push($this->authors, $this->clean($_author));
		}

	function setSubjectGeneral($_subjectGeneral){
		$this->subjectGeneral = $this->clean($_subjectGeneral);
	}

	function setDepartment($_department){
		$this->department = $this->clean($_department);
	}

	/**************** Additional Setters ******************/

	function addProvenance($sac_provenance) {
			array_push($this->sac_provenances, $this->clean($sac_provenance));
	}

	function setIdentifier($sac_theidentifier) {
			$this->sac_identifier = $sac_theidentifier;
	}

	function setStatusStatement($sac_thestatus) {
			$this->sac_statusstatement = $sac_thestatus;
	}

	function setCopyrightHolder($sac_thecopyrightholder) {
			$this->sac_copyrightHolder = $sac_thecopyrightholder;
	}

	function setCustodian($sac_thecustodian) {
			$this->sac_custodian = $this->clean($sac_thecustodian);
	}

	function setCitation($sac_thecitation) {
			$this->sac_citation = $this->clean($sac_thecitation);
	}


	/********************** Functions for Writing Mets *******************/


	function printObject(){
		echo "File List:<br />";
		print_r($this->files);
		echo "<br />";
		echo "Final Root:<br />
			$this->finalRootIn<br />
			Supps Root<br />
			$this->suppRootIn<br />
			Zips Root:<br />
			$this->zipRootOut<br />
			Zips File<br />
			$this->zipFileOut<br />
			Mets Root<br />
			$this->metsRootOut<br />
			Mets File<br />
			$this->metadataFilename";
	}

	/**
	 * @see CSUNMetaLab\SwordUploader\Contracts\PackagerContract
	 */
	public function package() {
		// Write the metadata (mets) file
		$mets_fh = @fopen($this->metsRootOut.'/'.$this->metadataFilename, 'w');
		if (!$mets_fh) {
			throw new CannotWritePackageMetadataException("Error writing metadata file (" . 
				$this->metsRootOut . '/' . $this->metadataFilename . ")");
		}
		$this->writeHeader($mets_fh);
		$this->writeDmdSec($mets_fh);
		$this->writeFileGrp($mets_fh);
		$this->writeStructMap($mets_fh);
		$this->writeFooter($mets_fh);    
		fclose($mets_fh);     
		// Create the zipped package
		if (class_exists("ZipArchive")) {
			$zip = new ZipArchive();
			$result = $zip->open($this->zipRootOut.'/'.$this->zipFileOut, ZIPARCHIVE::CREATE);
			if($result === TRUE) {
				// Add the mets file
				$zip->addFile($this->metsRootOut.'/'.$this->metadataFilename, 'mets.xml');
				// Add all thesis files
				foreach ($this->files as $value){
					if($value["fileType"]=="final"){
						$fileRoot = $this->finalRootIn;
					}
					else if($value["fileType"]=="supp"){
						$fileRoot = $this->suppRootIn;
					}
					$zip->addFile($fileRoot.'/'.$value["basename"], $value["originalName"]); 
				}
				$zip->close();
			}
			else
			{
				throw new CannotCreatePackageException("Could not open package zip file for writing.");
			}
		} else {
			throw new CannotCreatePackageDependencyException("Error creating package zip file. ZipArchive not installed.");
		}
	}

		function writeheader($fh) {
			fwrite($fh, "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"no\" ?" . ">\n");
			fwrite($fh, "<mets ID=\"sort-mets_mets\" OBJID=\"sword-mets\" LABEL=\"DSpace SWORD Item\" PROFILE=\"DSpace METS SIP Profile 1.0\" xmlns=\"http://www.loc.gov/METS/\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.loc.gov/METS/ http://www.loc.gov/standards/mets/mets.xsd\">\n");
			fwrite($fh, "\t<metsHdr CREATEDATE=\"2008-09-04T00:00:00\">\n");
			fwrite($fh, "\t\t<agent ROLE=\"CUSTODIAN\" TYPE=\"ORGANIZATION\">\n");
			if (isset($this->custodian)) { fwrite($fh, "\t\t\t<name>$this->custodian</name>\n"); }
			else { fwrite($fh, "\t\t\t<name>Unknown</name>\n"); }
				fwrite($fh, "\t\t</agent>\n");
			fwrite($fh, "\t</metsHdr>\n");
		}

		function writeDmdSec($fh) {
			fwrite($fh, "<dmdSec ID=\"sword-mets-dmd-1\" GROUPID=\"sword-mets-dmd-1_group-1\">\n");
			fwrite($fh, "<mdWrap LABEL=\"SWAP Metadata\" MDTYPE=\"OTHER\" OTHERMDTYPE=\"EPDCX\" MIMETYPE=\"text/xml\">\n");
			fwrite($fh, "<xmlData>\n");
			fwrite($fh, "<epdcx:descriptionSet xmlns:epdcx=\"http://purl.org/eprint/epdcx/2006-11-16/\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://purl.org/eprint/epdcx/2006-11-16/ http://purl.org/eprint/epdcx/xsd/2006-11-16/epdcx.xsd\">\n");
			fwrite($fh, "<epdcx:description epdcx:resourceId=\"sword-mets-epdcx-1\">\n");

			//write line for issueDate
			if(isset($this->issueDate)){
				$this->statement($fh, "http://purl.org/dc/terms/available",
					$this->valueStringSesURI("http://purl.org/dc/terms/W3CDTF", $this->issueDate));
				}

		//write line for copyrightDate
		if(isset($this->copyrightDate)){
			$this->customStatement($fh, "copyrightDate",
				$this->valueString($this->copyrightDate));
				}

		// write line for submittedDate
		if(isset($this->submittedDate)){
			//$this->customStatement($fh, "submittedDate",
			//	$this->valueString($this->submittedDate));
			$this->statement($fh, "http://purl.org/dc/terms/dateSubmitted",
				$this->valueStringSesURI("http://purl.org/dc/terms/W3CDTF", $this->submittedDate));
			//$this->customStatement($fh, "dateSubmitted",
			//	$this->valueString($this->submittedDate));
				}

		//write line for language
		if (isset($this->language)) {
			$this->customStatement($fh, "recordLanguage",
				$this->valueString($this->language));
				}

		//write line for publisher
		if (isset($this->publisher)){
			$this->statement($fh, "http://purl.org/dc/elements/1.1/publisher",
				$this->valueString($this->publisher));
				}

		//write line for rights
		if (isset($this->rights)){
			$this->customStatement($fh, "rights", $this->valueString($this->rights));
				}

		//write line for rightsURI
		if (isset($this->rightsURI)){
			$this->customStatement($fh, "rightsURI", $this->valueString($this->rightsURI));
				}

		//write line for rightsLicense
		if (isset($this->rightsLicense)){
			$this->customStatement($fh, "rightsLicense", $this->valueString($this->rightsLicense));
				}

		//write line for advisor
		if (isset($this->advisor)) {
			$this->customStatement($fh, "advisor", $this->valueString($this->advisor));
				}

		//write lines for committee (will have multiple values)
		foreach ($this->committee as $committee) {
			$this->customStatement($fh, "committeeMember", $this->valueString($committee));
		}

		//write line for degree
		if (isset($this->degree)){
			$this->customStatement($fh, "degree", $this->valueString($this->degree));
				}

		//write line for description
		if (isset($this->description)){
			$this->customStatement($fh, "description", $this->valueString($this->description));
				}

		//write line for abstract
		if (isset($this->abstract)){
			$this->statement($fh, "http://purl.org/dc/terms/abstract", $this->valueString($this->abstract));
				}

		//write line for statement of responsibility
		if (isset($this->statementOfResponsibility)){
			$this->customStatement($fh, "statementOfResponsibility",
				$this->valueString($this->statementOfResponsibility));
				}

		//write line for extent
		if (isset($this->extent)){
			$this->customStatement($fh, "extent", $this->valueString($this->extent));
				}

		//write lines for subjectKeywords (there will be multiple)
		foreach ($this->subjectKeywords as $subjectKeywords) {
			$this->customStatement($fh, "subjectKeywords", $this->valueString($subjectKeywords));
		}

		//write line for title
		if (isset($this->title)) {
			$this->statement($fh, "http://purl.org/dc/elements/1.1/title", 
				$this->valueString($this->title));
				}

		//write line for type
		if (isset($this->type)) {
			$this->customStatement($fh,"type", $this->valueString($this->type));
				}

		//write line for embargoLift --> Change to embargounit per new dspace on 4/3/2014
		if(isset($this->embargoLift)){
			$this->customStatement($fh, "embargountil", $this->valueString($this->embargoLift));
		}

		//write line for embargoTerms
		if(isset($this->embargoTerms)){
			$this->customStatement($fh, "embargoterms", $this->valueString($this->embargoTerms));
		}

		//write lines for creators / author -- currently ETD only supports single authors
		foreach ($this->authors as $author) {
			$this->statement($fh,"http://purl.org/dc/elements/1.1/creator",
				$this->valueString($author));
				}

		//write line for subjectGeneral
		if (isset($this->subjectGeneral)) {
			$this->customStatement($fh, "subjectGeneral", $this->valueString($this->subjectGeneral));
				}

		//write line for department
		if (isset($this->department)) {
			$this->customStatement($fh, "department", $this->valueString($this->department));
				}

		// Provenances, rights, and identifier 
				foreach ($this->sac_provenances as $sac_provenance) {
						$this->statement($fh,
														 "http://purl.org/dc/terms/provenance",
														 $this->valueString($sac_provenance));
				}

				foreach ($this->sac_rights as $sac_right) {
						$this->statement($fh,
														 "http://purl.org/dc/terms/rights",
														 $this->valueString($sac_right));
				}

				if (isset($this->sac_identifier)) {
						$this->statement($fh,
														 "http://purl.org/dc/elements/1.1/identifier", 
														 $this->valueString($this->sac_identifier));
				}
		 

				fwrite($fh, "<epdcx:statement epdcx:propertyURI=\"http://purl.org/eprint/terms/isExpressedAs\" " .
					"epdcx:valueRef=\"sword-mets-expr-1\" />\n");

				fwrite($fh, "</epdcx:description>\n");

				fwrite($fh, "<epdcx:description epdcx:resourceId=\"sword-mets-expr-1\">\n");

				$this->statementValueURI($fh, 
					"http://purl.org/dc/elements/1.1/type", 
					"http://purl.org/eprint/entityType/Expression");

				$this->statementVesURIValueURI($fh, 
					"http://purl.org/dc/elements/1.1/type",
					"http://purl.org/eprint/terms/Type",
					"http://purl.org/eprint/entityType/Expression");


				if (isset($this->sac_statusstatement)) {
						$this->statementVesURIValueURI($fh, 
							 "http://purl.org/eprint/terms/Status",
							 "http://purl.org/eprint/terms/Status",
							 $this->sac_statusstatement);
				}

				if (isset($this->sac_copyrightHolder)) {
						$this->statement($fh, 
							 "http://purl.org/eprint/terms/copyrightHolder", 
							 $this->valueString($this->sac_copyrightHolder));
				}

				if (isset($this->sac_citation)) {
						$this->statement($fh, 
							 "http://purl.org/eprint/terms/bibliographicCitation", 
							 $this->valueString($this->sac_citation));
				}

				fwrite($fh, "</epdcx:description>\n");   
				fwrite($fh, "</epdcx:descriptionSet>\n");
				fwrite($fh, "</xmlData>\n");
				fwrite($fh, "</mdWrap>\n");
				fwrite($fh, "</dmdSec>\n");  
		}

		function writeFileGrp($fh) {
			fwrite($fh, "\t<fileSec>\n");
			fwrite($fh, "\t\t<fileGrp ID=\"sword-mets-fgrp-1\" USE=\"CONTENT\">\n");
			for ($i = 0; $i < count($this->files); $i++) {
				fwrite($fh, "\t\t\t<file GROUPID=\"sword-mets-fgid-0\" ID=\"sword-mets-file-" . $i ."\" " .
					"MIMETYPE=\"" . $this->files[$i]["mimeType"] . "\">\n");
				fwrite($fh, "\t\t\t\t<FLocat LOCTYPE=\"URL\" xlink:href=\"" . $this->clean($this->files[$i]["originalName"]) . "\" />\n");
				fwrite($fh, "\t\t\t</file>\n");
				}
				fwrite($fh, "\t\t</fileGrp>\n");
				fwrite($fh, "\t</fileSec>\n");
		}

		function writeStructMap($fh) {
			fwrite($fh, "\t<structMap ID=\"sword-mets-struct-1\" LABEL=\"structure\" TYPE=\"LOGICAL\">\n");
			fwrite($fh, "\t\t<div ID=\"sword-mets-div-1\" DMDID=\"sword-mets-dmd-1\" TYPE=\"SWORD Object\">\n");
			fwrite($fh, "\t\t\t<div ID=\"sword-mets-div-2\" TYPE=\"File\">\n");
			for ($i = 0; $i < count($this->files); $i++) {
				fwrite($fh, "\t\t\t\t<fptr FILEID=\"sword-mets-file-" . $i . "\" />\n");
				}
				fwrite($fh, "\t\t\t</div>\n");
				fwrite($fh, "\t\t</div>\n");
				fwrite($fh, "\t</structMap>\n");
		}

		function writeFooter($fh) {
			fwrite($fh, "</mets>\n");
		}

		function valueString($value) {
			return "<epdcx:valueString>" .
				$value . 
				"</epdcx:valueString>\n";
		}

		function valueStringSesURI($sesURI, $value) {
			return "<epdcx:valueString epdcx:sesURI=\"" . $sesURI . "\">" .
				$value . 
				"</epdcx:valueString>\n";
		}

		function statement($fh, $propertyURI, $value) {
			fwrite($fh, "<epdcx:statement epdcx:propertyURI=\"" . $propertyURI . "\">\n" .
				$value .
				"</epdcx:statement>\n");
		}

	function customStatement($fh, $attributeName, $value) {
		fwrite($fh, "<epdcx:statement epdcx:attributeName=\"" . $attributeName . "\">\n" .
			$value .
			"</epdcx:statement>\n");
		}

		function statementValueURI($fh, $propertyURI, $value) {
			fwrite($fh, "<epdcx:statement epdcx:propertyURI=\"" . $propertyURI . "\" " .
				"epdcx:valueURI=\"" . $value . "\" />\n");
		}

		function statementVesURI($fh, $propertyURI, $vesURI, $value) {
			fwrite($fh, "<epdcx:statement epdcx:propertyURI=\"" . $propertyURI . "\" " .
				"epdcx:vesURI=\"" . $vesURI . "\">\n" .
				$value . 
				"</epdcx:statement>\n");
		}

		function statementVesURIValueURI($fh, $propertyURI, $vesURI, $value) {
			fwrite($fh, "<epdcx:statement epdcx:propertyURI=\"" . $propertyURI . "\" " .
				"epdcx:vesURI=\"" . $vesURI . "\" " .
				"epdcx:valueURI=\"" . $value . "\" />\n");
		}

		function clean($data) {
			return str_replace('&#039;', '&apos;', htmlspecialchars($data, ENT_QUOTES));
		}
}