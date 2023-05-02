<?php

class Movie extends MovieContr {

    private $id;
    private $title;
    private $synopsis;
    private $totalScore;
    private $totalRatingsReceived;
    private $runtimeMin;
    private $trailerURL;
    private $startDate;
    private $endDate;
    private $poster;
    private $language;
    private $genre;


    public function __construct($id=NULL, $title=NULL, $synopsis=NULL, $totalScore=NULL, $totalRatingsReceived=NULL, $runtimeMin=NULL, $trailerURL=NULL, $startDate=NULL, $endDate=NULL, $poster=NULL, $language=NULL, $genre=NULL) {
        $this->id = $id;
        $this->title = $title;
        $this->synopsis = $synopsis;
        $this->totalScore = $totalScore;
        $this->totalRatingsReceived = $totalRatingsReceived;
        $this->runtimeMin = $runtimeMin;
        $this->trailerURL = $trailerURL;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->poster = $poster;
        $this->language = $language;
        $this->genre = $genre;
    }

    public function getId() {
        return $this->id;
    }
    public function getTitle() {
        return $this->title;
    }
    public function getSynopsis() {
        return $this->synopsis;
    }
    public function getTotalScore() {
        return $this->totalScore;
    }
    public function getTotalRatingsReceived() {
        return $this->totalRatingsReceived;
    }
    public function getRuntimeMin() {
        return $this->runtimeMin;
    }
    public function getTrailerURL() {
        return $this->trailerURL;
    }
    public function getStartDate() {
        return $this->startDate;
    }
    public function getEndDate() {
        return $this->endDate;
    }
    public function getPoster() {
        return $this->poster;
    }
    public function getLanguage() {
        return $this->language;
    }
    public function getGenre() {
        return $this->genre;
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function setTitle($title) {
        $this->title = $title;
    }
    public function setSynopsis($synopsis) {
        $this->synopsis = $synopsis;
    }
    public function setTotalScore($totalScore) {
        $this->totalScore = $totalScore;
    }
    public function setTotalRatingsReceived($totalRatingsReceived) {
        $this->totalRatingsReceived = $totalRatingsReceived;
    }
    public function setRuntimeMin($runtimeMin) {
        $this->runtimeMin = $runtimeMin;
    }
    public function setTrailerURL($trailerURL) {
        $this->trailerURL = $trailerURL;
    }
    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }
    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }
    public function setPoster($poster) {
        $this->poster = $poster;
    }
    public function setLanguage($language) {
        $this->language = $language;
    }
    public function setGenre($genre) {
        $this->genre = $genre;
    }
}