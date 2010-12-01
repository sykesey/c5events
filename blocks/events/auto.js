var EventsBlock = {
	
	init:function(){},	
	
	currentID:0,
	
	chooseImg:function(ID){
		if (ID != null)
			this.currentID = ID;
		else
			this.currentID = 0;

		ccm_launchFileManager('&fType=' + ccmi18n_filemanager.FTYPE_IMAGE);
	},
	removeImg:function(ID){
		if (ID != null)
		{
			$('#fID_'+ID).val(0);
			$('#fID_title_'+ID).html('');
			$('#fID_bg_'+ID).css('background','');
		}
		else
		{
			
			$('#fID').val(0);
			$('#fID_thumbpath').val('');
			$('#fID_title').html('');
			$('#fID_bg').css('background','');
		}
	},
	
	selectObj:function(obj)
	{
		//for (var item in obj)
		//	alert(item + ":" + obj[item]);
		if (this.currentID > 0)
		{
			$('#fID_'+this.currentID).val(obj.fID);
			$('#fID_title_'+this.currentID).html(obj.title);
			$('#fID_bg_'+this.currentID).css('background','url('+obj.thumbnailLevel1+') no-repeat top left');
		}
		else
		{
			$('#fID').val(obj.fID);
			$('#fID_thumbpath').val(obj.thumbnailLevel1);
			$('#fID_title').html(obj.title);
			$('#fID_bg').css('background','url('+obj.thumbnailLevel1+') no-repeat top left');
		}
	},
	
	showEvents:function(){
		$("#ccm-eventsBlock-eventRows").show();
	},

	showAddEvent: function()
	{
		$('#ccm-eventsBlock-addEventFormWrap').show();
		$('#ccm-eventsBlock-addEventButton').hide();
	},
	hideAddEvent: function()
	{
		$('#ccm-eventsBlock-addEventFormWrap').hide();
		$('#ccm-eventsBlock-addEventButton').show();
		this.clearAddEvent();
	},
	clearAddEvent: function()
	{
		$('#event_name').val('');
		$('#event_date').val('');
		$('#publish_from').val('');
		$('#publish_to').val('');
		$('#short_description').val('');
		$('#fID').val('0');
		$('#fID_title').html('');
		$('#fID_bg').css('background','none');
	},
	
	addEvents:0, 
	addNewEvent: function() {
		this.addEvents--; //negative counter - so it doesn't compete with real galleryImgIds
		var eventsEventId=this.addEvents;
		var templateHTML=$('#eventRowTemplateWrap .ccm-eventsBlock-eventRow').html();
		templateHTML=templateHTML.replace(/tempEventsEventId/g,eventsEventId);
		templateHTML=templateHTML.replace(/tempName/g,$('#event_name').val());
		templateHTML=templateHTML.replace(/tempEventDate/g,$('#event_date').val());
		templateHTML=templateHTML.replace(/tempPublishFrom/g,$('#publish_from').val());
		templateHTML=templateHTML.replace(/tempPublishTo/g,$('#publish_to').val());
		templateHTML=templateHTML.replace(/tempShortDescription/g,$('#short_description').val());
		templateHTML=templateHTML.replace(/tempThumbPath/g,$('#fID_thumbpath').val());
		templateHTML=templateHTML.replace(/tempfileName/g,$('#fID_title').text());
		templateHTML=templateHTML.replace(/tempfID/g,$('#fID').val());
		var eventRow = document.createElement("div");
		eventRow.innerHTML=templateHTML;
		eventRow.id='ccm-eventsBlock-eventRow'+parseInt(eventsEventId);	
		eventRow.className='ccm-eventsBlock-eventRow';
		document.getElementById('ccm-eventsBlock-eventRows').appendChild(eventRow);
		//var bgRow=$('#ccm-eventsBlock-eventRow'+parseInt(fID)+' .backgroundRow');
		this.clearAddEvent();
		this.hideAddEvent();
		//$('#event_date_' + eventsEventId ).datepicker({ changeYear: true, showAnim: 'fadeIn' });
		//$('#event_date_' + eventsEventId ).datepicker({ changeYear: true, showAnim: 'fadeIn' });
	},
	
	removeEvent: function(fID){
		$('#ccm-eventsBlock-eventRow'+fID).remove();
	},
	
	moveUp:function(fID){
		var thisImg=$('#ccm-eventsBlock-eventRow'+fID);
		var qIDs=this.serialize();
		var previousQID=0;
		for(var i=0;i<qIDs.length;i++){
			if(qIDs[i]==fID){
				if(previousQID==0) break; 
				thisImg.after($('#ccm-eventsBlock-eventRow'+previousQID));
				break;
			}
			previousQID=qIDs[i];
		}	 
	},
	moveDown:function(fID){
		var thisImg=$('#ccm-eventsBlock-eventRow'+fID);
		var qIDs=this.serialize();
		var thisQIDfound=0;
		for(var i=0;i<qIDs.length;i++){
			if(qIDs[i]==fID){
				thisQIDfound=1;
				continue;
			}
			if(thisQIDfound){
				$('#ccm-eventsBlock-eventRow'+qIDs[i]).after(thisImg);
				break;
			}
		} 
	},
	serialize:function(){
		var t = document.getElementById("ccm-eventsBlock-eventRows");
		var qIDs=[];
		for(var i=0;i<t.childNodes.length;i++){ 
			if( t.childNodes[i].className && t.childNodes[i].className.indexOf('ccm-eventsBlock-eventRow')>=0 ){ 
				var qID=t.childNodes[i].id.replace('ccm-eventsBlock-eventRow','');
				qIDs.push(qID);
			}
		}
		return qIDs;
	},	

	validate:function(){
		var failed=0; 
		
		
		return true;
	} 
}

ccmValidateBlockForm = function() { return EventsBlock.validate(); }
ccm_chooseAsset = function(obj) { EventsBlock.selectObj(obj); }

$(function() {
	EventsBlock.showEvents();
	
});

