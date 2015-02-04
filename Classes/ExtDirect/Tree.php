<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2011 Mathieu Sanchez <msa@atolcd.com> -
*           Alexandre Nicolas <ani@atolcd.com> - Nicolas Forgeot <nfo@atolcd.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

//require_once(t3lib_extMgm::extPath('atol_cmis_libs', 'cmis/AtolCMIS_cmis_repository_wrapper.php'));
class Tx_AtolCmisList_ExtDirect_Tree{
	protected $client;	
	

	public function connect($uid) {	
		$repository = $this->getRepository($uid);		
		$this->client = new AtolCMIS_cmis_repository_wrapper($repository['url'], $repository['login'], $repository['password']);	
	}
		
	/**
	*
	* @param string $sID
	* @return array
	*/
	public function getRootFolderInfo($sID)
	{			
		$this->connect($sID);
		$myfolder = $this->client->getObjectByPath('/');
		
		$properties = $this->transformPropertiesName($myfolder->properties); // s/:/\/g dans les noms de propriétés
		$properties['cmis-edit-media'] = $myfolder->links['edit-media'];
		
		if(!$myfolder->properties['cmis:name'])
			$myfolder->properties['cmis:name'] = 'Root';
			
		$data = array(
			'id' => $myfolder->id,
			'iconCls' => $myfolder->properties['cmis:baseTypeId'],
			'text' => $myfolder->properties['cmis:name'],
			'leaf' => false
		  );			
		return $data;	
	}
	
  

	/* ----------------------------------------------------------------------------------------
	*
	-------------------------------------------------------------------------------------------*/
 
  /**
  * @param array Current flexform configuration
  * @return array Updated configuration
  */
	public function getCMISTreeBe($parameter) {	

    if(!$repository = $this->getRepository($parameter->sID)){
      return array(
        'total' => 0,
        'data' => array()
      );
    }
      $this->connect($parameter->sID);
      $repo_folder = $parameter->path ? $parameter->path : '/';

      $myfolder = $this->client->getObjectByPath($repo_folder);
      $objs = $this->client->getChildren($myfolder->id);	
      $filtre = $parameter->folder;      
      $data = array();
      
    foreach ($objs->objectList as $obj) {
      $row = array();
      $leaf = false;
      
      if ($obj->properties['cmis:baseTypeId'] == "cmis:folder") {
        $type = 'task-folder';
        $properties = $this->transformPropertiesName($obj->properties); // s/:/\/g dans les noms de propriétés
        $properties['cmis-edit-media'] = $obj->links['edit-media'];
        $data[] = array(
          'id' => $obj->id,
          'iconCls' => $type,
          'title' => $obj->properties['cmis:name'],
          'path' => $obj->properties['cmis:path'],
          'expanded' => false,
          'leaf' => $leaf,
          'properties' => $properties,
        );
      } 
      else if($obj->properties['cmis:baseTypeId'] == "cmis:document" && !$filtre){
        $data[] = array(
          'id' => $obj->id,
          'iconCls' => $type,
          'title' => $obj->properties['cmis:name'],
          'path' => $obj->properties['cmis:path'],
          'expanded' => false,
          'leaf' => true,
          'properties' => $properties,
        );
      }
      else {
        $type = 'Unknown';
      }
    }
      $result = array(
        'total' => count($data),
        'data' => $data
      );  
    
    return json_encode($data);
  } 
	
  private function transformPropertiesName($properties) {
		$len = count($properties);
			return array_combine(
				array_map("preg_replace", array_fill(0, $len, '/:/'), array_fill(0, $len, '-'), array_keys($properties)), 
				array_values($properties)
		);
	}
	
  public function getRepository($uid) {
		$uid = "and uid = $uid";
      
		$where =  "deleted = 0 and hidden = 0 ".$uid;
		$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'tx_atolcmis_repository', $where,'', 'sorting', 1);
		$firstRepository = $rows ? $rows[0] : false;
	
		return $firstRepository;
	} 
  
  public function getRepositories() {
    $rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('*', 'tx_atolcmis_repository', 'deleted = 0 and hidden = 0', '', 'sorting');
    return array(
      'total' => count($rows),
      'data' => $rows
    );
  }

}
?>