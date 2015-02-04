/***************************************************************
*  Copyright notice
*
*  (c) 2010 Mathieu Sanchez <msa@atolcd.com>
*      2011 Alexandre Nicolas <ani@atolcd.com> - Nicolas Forgeot <nfo@atolcd.com>
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
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This script is a modified version of a script published under the htmlArea License.
*  A copy of the htmlArea License may be found in the textfile HTMLAREA_LICENSE.txt.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/*
 * Character Map Plugin for TYPO3 htmlArea RTE
 *
 * TYPO3 SVN ID: $Id: $
 */
Ext.ns('TYPO3.AtolCmis');


TYPO3.AtolCmis.Bus = new Ext.util.Observable();
TYPO3.AtolCmis.Bus.addEvents('clickdoc', 'repositoriesloaded');

TYPO3.AtolCmis.RepositoriesStore = new Ext.data.DirectStore({
  storeId: 'RepositoriesStore',
  root: 'data',
  totalProperty: 'total',
  idProperty: 'uid',
  fields: ['uid', 'title'],
});
TYPO3.AtolCmis.Data = {};

TYPO3.AtolCmis.TreeContainer = Ext.extend(Ext.ux.tree.TreeGrid, {
  title: 'CMIS Browser',
  enableDD: false,
  columns:[{
      header: 'Arborescence',
      dataIndex: 'title',
      width: 400
  },{
      header: 'Path',
      dataIndex: 'id',
      width: 400,
      align: 'center'
  }],
  autoScroll: true,
  sm: new Ext.grid.RowSelectionModel({singleSelect: true})
});
Ext.reg('cmisTree', TYPO3.AtolCmis.TreeContainer);

TYPO3.AtolCmis.DocDetail = Ext.extend(Ext.TabPanel, {
  activeTab: 0,
  updateDetail: function(data) {
    data['cmis-creationDate'] = new Date(data['cmis-creationDate']).toLocaleString();
    TYPO3.AtolCmis.Data.lien = data['cmis-edit-media'];
    TYPO3.AtolCmis.Data.name = data['cmis-name'];
    TYPO3.AtolCmis.Data.type = data['cmis-baseTypeId']; 
    this.getComponent('infotab').update(data);
  }
});
Ext.reg('docDetail', TYPO3.AtolCmis.DocDetail);

var infoDocTab = {
  title: 'Info',
  html: 'Select a folder',
  itemId: 'infotab',
  tpl: new Ext.Template([
    '<p>Name : {cmis-name}</p>',
    '<p>Created on : {cmis-creationDate}</p>',
    '<p>Created by : {cmis-createdBy}</p>'
  ].join(''), {compiled: true})
};

TYPO3.AtolCmis.Combo = Ext.extend(Ext.form.ComboBox, {
  itemId: 'selectRepository',
  width: 300,
  valueField: 'uid',
  displayField: 'title',
  mode: 'local',
  triggerAction: 'all',
  editable: false,
  initComponent: function() {
    var me = this;
    this.store.on('load',function(store) {
      var firstRepository = {
        title: store.getAt(0).get('title'),
        url: store.getAt(0).get('uid')
      }
      TYPO3.AtolCmis.Data.sid = store.getAt(0).get('uid');
      me.setValue(firstRepository.title);
    });
    this.store.load();
    TYPO3.AtolCmis.Combo.superclass.initComponent.call(this);
  }
});
Ext.reg('cmisCombo', TYPO3.AtolCmis.Combo);
TYPO3.AtolCmis.App = Ext.extend(Ext.Panel, {
  id: 'cmisPanel',
  initComponent: function() {
    TYPO3.AtolCmis.RepositoriesStore.proxy = new Ext.data.DirectProxy({
      //directFn: TYPO3.AtolCmis.Tree.getRepositories
      directFn: TYPO3.AtolCmisList.Tree.getRepositories
    });
    treeLoader = new Ext.tree.TreeLoader({
      directFn: TYPO3.AtolCmisList.Tree.getCMISTreeBe,
      baseParams: {
        path: '/',
        folder:true,
      },
      paramsAsHash: true
    });
    treeLoader.on('beforeload', function(l, n) {
      l.baseParams.path = n.attributes.path;
    });
    Ext.applyIf(this, {
      frame: true,
      title: 'CMIS Browser',
      itemId: 'cmispanel',
      items: [{
          xtype: 'cmisCombo',
          store: TYPO3.AtolCmis.RepositoriesStore
      }, {
        xtype: 'cmisTree',
        itemId: 'cmis',
        height: 300,
        cls: "cmistreepanel",
        loader: treeLoader
      }, {
        xtype: 'docDetail',
        height: 150,
        itemId: 'detail',
        items: [infoDocTab]
      }]
    });
    TYPO3.AtolCmis.App.superclass.initComponent.call(this);
  },
  initEvents: function() {
    TYPO3.AtolCmis.App.superclass.initEvents.call(this);
    this.on('render', function() {
      var cmisTree = this.getComponent('cmis');
      cmisTree.getRootNode().reload();
    }, this);
    var cmisTree = this.getComponent('cmis');
    var select = this.getComponent('selectRepository');
    select.on('select', function(cmp, rec, index) {
      cmisTree.loader.baseParams.sID = rec.get('uid');
      cmisTree.loader.baseParams.path = '/';
      TYPO3.AtolCmis.Data.sid = rec.get('uid');
      cmisTree.getRootNode().reload();
    });
    var treeGrid = this.getComponent('cmis');
    treeGrid.on('click', function(n){
      TYPO3.AtolCmis.Bus.fireEvent('clickdoc', n.leaf);
      var detail = this.getComponent('detail');
      TYPO3.AtolCmis.Data.objectId = n.id;
      detail.updateDetail(n.attributes.properties);
    }, this);
  }
});
Ext.reg('cmisApp', TYPO3.AtolCmis.App);
 
TYPO3.AtolCmis.openDial = function(hn){

  var validate = function (btn){
    if(TYPO3.AtolCmis.Data.type=='cmis:folder'){
      document.editform[hn].value=TYPO3.AtolCmis.Data.name+';;_tx_;;'+TYPO3.AtolCmis.Data.objectId+';;_tx_;;'+TYPO3.AtolCmis.Data.sid;
      document.editform[hn+'_0'].value=TYPO3.AtolCmis.Data.name;
      close();
    }
    else{
      alert("Please select a folder before validating.");//Veuillez sélectionner un dossier afin de valider
    }
  }
  
  var close = function (btn){
    TYPO3.AtolCmis.cmisDial.hide();
    
  }

  var toggle = function (btn){
    var cmisApp = Ext.getCmp('cmisPanel');
    var cmisTree = cmisApp.getComponent('cmis');
    
    cmisTree.loader.baseParams.folder=!cmisTree.loader.baseParams.folder;
    cmisTree.getRootNode().reload();
    
    if(!cmisTree.loader.baseParams.folder)
      btn.setText('Folders');
    else
      btn.setText('Files');
  }
  TYPO3.AtolCmis.cmisDial = new Ext.Window({
    title: 'CMIS Browser',
    cls: 'CmisList-window',
    border: false,
    width: 500,
    itemId: 'cmiswindow',
    resizable: !Ext.isIE,
    closeAction: 'hide',
    items: {
    xtype: 'cmisApp'
    },
    listeners: {
      beforeclose: {
        fn: function() {
          this.hide();
        },
        scope: this
      }
    },
    buttons : [
            {
                text    : 'Ok',
                handler : validate
            },
            {
                text    : 'Close',
                handler : close
            },
            {
              text      : 'Files',
              itemId    : 'toggleButton',
              handler : toggle
            }
        ]
  });
  TYPO3.AtolCmis.cmisDial.show();
};
