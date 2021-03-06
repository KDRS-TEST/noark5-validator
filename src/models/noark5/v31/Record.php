<?php

require_once ('models/noark5/v31/Series.php');
require_once ('models/noark5/v31/File.php');
require_once ('models/noark5/v31/Klass.php');
require_once ('models/noark5/v31/StorageLocation.php');
require_once ('models/noark5/v31/DocumentDescription.php');
require_once ('models/noark5/v31/DocumentObject.php');
//require_once ('models/noark5/v31/BasicRecord.php');
//require_once ('models/noark5/v31/RegistryEntry.php');
require_once ('utils/Constants.php');

/**
  * @Entity @Table(name="record")
  * @InheritanceType("JOINED")
  * @DiscriminatorColumn(name="discr", type="string")
  * @DiscriminatorMap({"record" = "Record", "basicrecord" = "BasicRecord", "registryentry" = "RegistryEntry"})
  *
  **/
class Record
{
    /** @Id @Column(type="bigint", name="pk_record_id", nullable=false) @GeneratedValue **/
    protected $id;

    /** M001 - systemID (xs:string) */
    /**  @Column(type="string", name="system_id", nullable=true) **/
    protected $systemId;

    /** M600 - opprettetDato (xs:dateTime) */
    /**  @Column(type="datetime", name="created_date", nullable=true) **/
    protected $createdDate;

    /** M601 - opprettetAv (xs:string) */
    /**  @Column(type="string", name="created_by", nullable=true) **/
    protected $createdBy;

 	/** M604 - arkivertDato (xs:dateTime) */
    /**  @Column(type="datetime", name="archived_date", nullable=true) **/
    protected $archivedDate;

	/** M605 - arkivertAv (xs:string) */
    /**  @Column(type="string", name="archived_by", nullable=true) **/
    protected $archivedBy;

    // Link to File
    /** @ManyToOne(targetEntity="File", fetch="EXTRA_LAZY", cascade={"persist", "remove"})
     *   @JoinColumn(name="record_file_id",
     *        referencedColumnName="pk_file_id")
     **/
    protected $referenceFile;

    // Link to Series
    /** @ManyToOne(targetEntity="Series", fetch="EXTRA_LAZY", cascade={"persist", "remove"})
     *   @JoinColumn(name="record_series_id",
     *        referencedColumnName="pk_series_id")
     **/
    protected $referenceSeries;

    // Link to Class
    /** @ManyToOne(targetEntity="Klass", fetch="EXTRA_LAZY")
     *   @JoinColumn(name="record_class_id",
     *        referencedColumnName="pk_class_id")
     **/
    protected $referenceClass;

    // Links to DocumentDescriptions
    /** @ManyToMany(targetEntity="DocumentDescription", fetch="EXTRA_LAZY", cascade={"persist", "remove"})
     *   @JoinTable(name="record_document_description",
     *        joinColumns=@JoinColumn(
     *        name="f_pk_record_id",
     *        referencedColumnName="pk_record_id"),
     *    inverseJoinColumns=@JoinColumn(
     *        name="f_pk_document_description_id",
     *        referencedColumnName="pk_document_description_id"))
     * */
    protected $referenceDocumentDescription;

    // Links to DocumentObjects
    /** @OneToMany(targetEntity="DocumentObject", mappedBy="referenceRecord", fetch="EXTRA_LAZY") **/
    protected $referenceDocumentObject;

    /** @Embedded(class = "Screening") */
    protected $screening;

    function __construct()
    {}

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getSystemId()
    {
        return $this->systemId;
    }

    public function setSystemId($systemId)
    {
        $this->systemId = $systemId;
        return $this;
    }

    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    public function setCreatedDate($createdDate)
    {
         // have to convert from string object to datetime object
        $this->createdDate = DateTime::createFromFormat(Constants::XSD_DATETIME_FORMAT, $createdDate);
        return $this;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getArchivedDate()
    {
        return $this->archivedDate;
    }

    public function setArchivedDate($archivedDate)
    {
        // have to convert from string object to datetime object
        $this->archivedDate = DateTime::createFromFormat(Constants::XSD_DATETIME_FORMAT, $archivedDate);
        return $this;
    }

    public function getArchivedBy()
    {
        return $this->archivedBy;
    }

    public function setArchivedBy($archivedBy)
    {
        $this->archivedBy = $archivedBy;
        return $this;
    }

    public function getReferenceFile()
    {
        return $this->referenceFile;
    }

    public function setReferenceFile($referenceFile)
    {
        $this->referenceFile = $referenceFile;
        return $this;
    }

    public function getReferenceClass()
    {
        return $this->referenceClass;
    }

    public function setReferenceClass($referenceClass)
    {
        $this->referenceClass = $referenceClass;
        return $this;
    }

    public function getReferenceDocumentDescription()
    {
        return $this->referenceDocumentDescription;
    }

    public function setReferenceDocumentDescription($referenceDocumentDescription)
    {
        $this->referenceDocumentDescription = $referenceDocumentDescription;
        return $this;
    }

    public function addReferenceDocumentDescription($documentDescription)
    {
        $this->referenceDocumentDescription[] = $documentDescription;
        return $this;
    }

    public function getReferenceDocumentObject()
    {
        return $this->referenceDocumentObject;
    }

    public function setReferenceDocumentObject($referenceDocumentObject)
    {
        $this->referenceDocumentObject = $referenceDocumentObject;
        return $this;
    }

    public function addReferenceDocumentObject($documentObject)
    {
        $this->referenceDocumentObject[] = $documentObject;
        return $this;
    }

    public function getScreening()
    {
        return $this->screening;
    }

    public function setScreening($screening)
    {
        $this->screening = $screening;
        return $this;
    }

    public function getReferenceSeries()
    {
        return $this->referenceSeries;
    }

    public function setReferenceSeries($referenceSeries)
    {
        $this->referenceSeries = $referenceSeries;
        return $this;
    }

    public function __toString()
    {
        return __METHOD__ . " id[" . $this->id . "], " . "systemId[" . $this->systemId . "]";
    }


}

?>