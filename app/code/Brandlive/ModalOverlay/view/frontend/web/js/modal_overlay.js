define([
    'uiComponent',
    'jquery',
    'Magento_Ui/js/modal/modal'
], function (Component, $, modal) {
    'use strict';

    var cacheKey = 'modal-overlay';
 
    var set= function(nombre, valor, caducidad) {

        if(!caducidad)

            caducidad = 31

    
        var expireDate = new Date() 

        expireDate.setDate(expireDate.getDate()+caducidad);

        document.cookie = nombre + "=" + escape(valor) + "; expires=" + expireDate.toGMTString() + "; path=/";

    };

    var get = function(nombre)
    {
        if(document.cookie.length>0)
        {
            var start=document.cookie.indexOf(nombre + "=");

            if (start!=-1)
            {
                start=start + nombre.length+1;

                var end=document.cookie.indexOf(";",start);

                if (end==-1)

                    end=document.cookie.length;

                return JSON.parse(unescape(document.cookie.substring(start,end)));   
            }
        }
        return null;
    };

    var getData = function () {
        return get(cacheKey);
    };
 
    var saveData = function (data,duration) {
        set(cacheKey, JSON.stringify(data),duration);
    };

    var getModal_overlay=function(enabled){
        return {
            'modal_overlay': enabled,
            'postal_code':$("#postal_code").val()
        };
    };

    if ($.isEmptyObject(getData())) {  
        saveData(getModal_overlay(false),1);
    }else{
        if(window.location.pathname=='/'){
            saveData(getModal_overlay(false),1);
        } 
    };

    $("#send").click(function(e){
        if ($("#postal_code").val()==''){
            e.preventDefault();
            $("#postalcode-error").show();
            saveData(getModal_overlay(false),-1);
        }else{
            saveData(getModal_overlay(true),1);
        }
    });

    return Component.extend({
 
        initialize: function () {
 
            this._super();
            var options = {
                type: 'popup',
                responsive: true,
                innerScroll: false,
                title: false,
                buttons: false,
                opened: function($Event) {
                    $('.modal-header button.action-close', $Event.srcElement).remove();
                },
                keyEventHandlers: {
                    escapeKey: function () { return; }
                }
            };
 
            var modal_overlay_element = $('#modal-overlay');
            var popup = modal(options, modal_overlay_element);
 
            modal_overlay_element.css("display", "block");
 
            this.openModalOverlayModal();
 
        },
 
        openModalOverlayModal:function(){
            var modalContainer = $("#modal-overlay");
 
            if(this.getModalOverlay()) {
               return false;
            }
            
            modalContainer.modal('openModal');
        },
 
        setModalOverlay: function (data) {
                var obj = getData();
                obj.modal_overlay = data;
                saveData(obj,1);
        },
 
        getModalOverlay: function () {
            return getData().modal_overlay;
        }
 
    });
});