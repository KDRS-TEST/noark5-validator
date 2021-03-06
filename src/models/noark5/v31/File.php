<?php
use Doctrine\Common\Collections\ArrayCollection;
require_once ('models/noark5/v31/Series.php');
require_once ('models/noark5/v31/Klass.php');
require_once ('models/noark5/v31/Record.php');
require_once ('models/noark5/v31/StorageLocation.php');

/**
 * @Entity @Table(name="file")
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"file" = "File", "casefile" = "CaseFile", "meetingfile" = "MeetingFile"})
 **/
class File
{
    /** @Id @Column(type="bigint", name="pk_file_id", nullable=false) @GeneratedValue **/
    protected $id;

    /** M001 - systemID (xs:string) */
    /**  @Column(type="string", name="system_id", nullable=true) **/
    protected $systemId;

    /** M003 - mappeID (xs:string) */
    /** @Column(type="integer", name="file_id", nullable=true) **/
    protected $fileId;

    /** M020 - tittel (xs:string) */
    /**  @Column(type="string", name="title", nullable=true) **/
    protected $title;

    /** M025 - offentligTittel (xs:string) */
    /**  @Column(type="string", name="official_title", nullable=true) **/
    protected $officialTitle;

    /** M021 - beskrivelse (xs:string) */
    /**  @Column(type="string", name="description", nullable=true) **/
    protected $description;

    /** M300 - dokumentmedium (xs:string) */
    /**  @Column(type="string", name="document_medium", nullable=true) **/
    protected $documentMedium;

    /** M600 - opprettetDato (xs:dateTime) */
    /**  @Column(type="datetime", name="created_date", nullable=true) **/
    protected $createdDate;

    /** M601 - opprettetAv (xs:string) */
    /**  @Column(type="string", name="created_by", nullable=true) **/
    protected $createdBy;

    /** M602 - avsluttetDato (xs:dateTime) */
    /**  @Column(type="datetime", name="finalised_date", nullable=true) **/
    protected $finalisedDate;

    /** M603 - avsluttetAv (xs:string) */
    /**  @Column(type="string", name="finalised_by", nullable=true) **/
    protected $finalisedBy;

    // Links to Keywords
    /**
    * @ManyToMany(targetEntity="Keyword", inversedBy="referenceFile", fetch="EXTRA_LAZY")
    *       @JoinTable(name="file_keyword",
    *           joinColumns={@JoinColumn(name="f_pk_file_id", referencedColumnName="pk_file_id")},
    *            inverseJoinColumns={@JoinColumn(name="f_pk_keyword_id", referencedColumnName="pk_keyword_id")}
    *      )
    **/
    protected $keyword;

    // Link to StorageLocation
    /**
    *   @ManyToOne (targetEntity="StorageLocation", fetch="EXTRA_LAZY")
    *       @JoinColumn(name="file_storage_location_id",
    *         referencedColumnName="pk_storage_location_id")
    **/
    protected $referenceStorageLocation;

    // Link to parent File
    /**
    * @ManyToOne(targetEntity="File", inversedBy="referenceChildFile", fetch="EXTRA_LAZY")
    *   @JoinColumn(name="referenceParentFonds_pk_file_id", referencedColumnName="pk_file_id")
    * */
    protected $referenceParentFile;

    // Links to child Files
    /** @OneToMany(targetEntity="File", mappedBy="referenceParentFile", fetch="EXTRA_LAZY") **/
    protected $referenceChildFile;

    // Link to Series
    /**
    *   @ManyToOne(targetEntity="Series", fetch="EXTRA_LAZY")
    *       @JoinColumn(name="file_series_id",
    *           referencedColumnName="pk_series_id")
    **/
    protected $referenceSeries;

    // Link to Class
    /**
    *   @ManyToOne(targetEntity="Klass", fetch="EXTRA_LAZY")
    *       @JoinColumn(name="file_class_id",
    *        referencedColumnName="pk_class_id")
    **/
    protected $referenceClass;

    // Links to Records
    /** @OneToMany(targetEntity="Record", mappedBy="referenceRecord", cascade={"persist", "remove"}) **/
    protected $referenceRecord;


    public function __construct() {
        $this->referenceChildFile = new ArrayCollection();
        $this->referenceRecord = new ArrayCollection();
    }

    public function getId() {
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

    public function getFileId()
    {
        return $this->fileId;
    }

    public function setFileId($fileId)
    {
        $this->fileId = $fileId;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getOfficialTitle()
    {
        return $this->officialTitle;
    }

    public function setOfficialTitle($officialTitle)
    {
        $this->officialTitle = $officialTitle;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDocumentMedium()
    {
        return $this->documentMedium;
    }

    public function setDocumentMedium($documentMedium)
    {
        $this->documentMedium = $documentMedium;
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

    public function getFinalisedDate()
    {
        return $this->finalisedDate;
    }

    public function setFinalisedDate($finalisedDate)
    {
      // have to convert from string object to datetime object
        $this->finalisedDate = DateTime::createFromFormat(Constants::XSD_DATETIME_FORMAT, $finalisedDate);
        return $this;
    }

    public function getFinalisedBy()
    {
        return $this->finalisedBy;
    }

    public function setFinalisedBy($finalisedBy)
    {
        $this->finalisedBy = $finalisedBy;
        return $this;
    }

    public function getKeyword()
    {
        return $this->keyword;
    }

    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
        return $this;
    }

    public function getReferenceKeyword()
    {
        return $this->referenceKeyword;
    }

    public function setReferenceKeyword($referenceKeyword)
    {
        $this->referenceKeyword = $referenceKeyword;
        return $this;
    }

    /**
     * @return the $referenceStorageLocation
     */
    public function getReferenceStorageLocation()
    {
        return $this->referenceStorageLocation;
    }

    /**
     * @param field_type $referenceStorageLocation
     */
    public function setReferenceStorageLocation($referenceStorageLocation)
    {
        $this->referenceStorageLocation = $referenceStorageLocation;
    }

    public function addReferenceStorageLocation($storageLocation)
    {
        $this->referenceStorageLocation[] = $storageLocation;
        return $this;
    }

    public function getReferenceParentFile()
    {
        return $this->referenceParentFile;
    }

    public function setReferenceParentFile($referenceParentFile)
    {
        $this->referenceParentFile = $referenceParentFile;
        return $this;
    }

    public function getReferenceChildFile()
    {
        return $this->referenceChildFile;
    }

    public function setReferenceChildFile($referenceChildFile)
    {
        $this->referenceChildFile = $referenceChildFile;
        return $this;
    }

    public function addReferenceChildFile($referenceChildFile)
    {
        $this->referenceChildFile[] = $referenceChildFile;
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

    public function getReferenceClass()
    {
        return $this->referenceClass;
    }

    public function setReferenceClass($referenceClass)
    {
        $this->referenceClass = $referenceClass;
        return $this;
    }

    public function getReferenceRecord()
    {
        return $this->referenceRecord;
    }

    public function setReferenceRecord($referenceRecord)
    {
        $this->referenceRecord = $referenceRecord;
        return $this;
    }

    public function addReferenceRecord($referenceRecord)
    {
        $this->referenceRecord[] = $referenceRecord;
        return $this;
    }

    public function __toString()
    {
        return "id[" . $this->id . "], " . "systemId[" . $this->systemId . "]";
    }
}

?>