var settingJaservAjax = {
    targetPath : 'Gateinout.aspx',
    codeReloadToTargetPath : '=', //will redirect to the targetPath
    codeReloadFuncTrue : '1', //will run trueFunc if more than 1 please fill like this '1/2/3/4'
    codeReloadFuncFalse : '4', //will run trueFunc if more than 1 please fill like this '8/9/10/11'
    reloadFunc : false,
    alertFalseArgument : false
};
/*
objectData = {
    content : "",
    url : "",
    bool : true|false,
    methode : post|get,
    funcTrue : function(message){},
    funcFalse : function(message){},
    reloadFunc : true|false
}
 */
var jaservAjax = function (objectData){
    this.getStatusSettingConsystency = function(){
        if(settingJaservAjax.codeReloadToTargetPath == ''){
            return false;
        }
        if(settingJaservAjax.codeReloadToTargetPath.length >= 2){
            return false;
        }       
    };
    this.getXmlHttpRequest = function(){
        try{ return new XMLHttpRequest();
        }catch(err){ 
            try{ return new ActiveXObject("Msxml2.XMLHTTP");
            }catch(err){
                try{ return new ActiveXObject("Microsoft.XMLHTTP");
                }catch(err){ return false; } } } };
    this.isInTrue = function(char){
        if(char.length != 1) return false;
        if(!this.codeReloadFuncTrue) return false;
        var tempArray = this.codeReloadFuncTrue.split('/');
        var tempResult = false;
        for(i = 1; i <= tempArray.length; i++){
            if(tempArray[i-1] == char){
                tempResult = true;
            }
        }
        return tempResult;
    };
    this.isInFalse = function(char){
        if(char.length != 1) return false;
        if(!this.codeReloadFuncFalse) return false;
        var tempArray = this.codeReloadFuncFalse.split('/');
        var tempResult = false;
        for(i = 1; i<= tempArray.length; i++){
            if(tempArray[i-1] == char){
                tempResult = true;
            }
        } 
        return tempResult;
    };
    this.isGoToDefaultPath = function(char){
        if(char.length != 1) return false;
        if(!this.codeReloadToTargetPath) return false;
        //alert(this.codeReloadToTargetPath+" "+char);
        if(char == this.codeReloadToTargetPath) return true; else return false;
    };
    this.postFalse = function(){
        var tempAjax = this.getXmlHttpRequest();
        var tempThis = this;
        tempAjax.open('post', this.url,false);
        tempAjax.onreadystatechange = function(){
            if((tempAjax.readyState == 4)&&(tempAjax.status == 200)){
                tempResponseText = tempAjax.responseText;
                tempThis.funcProcess(tempResponseText.substr(1,tempResponseText.length-1));
                if(tempThis.isInFalse(tempResponseText[0])){
                    tempThis.funcFalse(tempResponseText.substr(1,tempResponseText.length-1));
                }else if(tempThis.isInTrue(tempResponseText[0])){
                    tempThis.funcTrue(tempResponseText.substr(1,tempResponseText.length-1));
                }else if(tempThis.isGoToDefaultPath(tempResponseText[0])){
                    window.location = window.location.origin+"/"+tempThis.targetPath;
                }else{
                    tempThis.funcAlternate(tempResponseText.substr(1,tempResponseText.length-1));
                }
                tempThis.tryReloadAsPosibble('postFalse');
            }else if((tempAjax.readyState == 4)&&(tempAjax.status == 0)){
                tempThis.postTrue();
            }else if(tempAjax.status > 400 && tempAjax != 404){
                tempThis.postTrue();
            }else{
                tempThis.showError('Page Not found');
            }
        };
        tempAjax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        tempAjax.send(this.content);
    };
    this.postTrue = function(){
        var tempAjax = this.getXmlHttpRequest();
        var tempThis = this;
        tempAjax.open('post', this.url,true);
        tempAjax.onreadystatechange = function(){
            if((tempAjax.readyState == 4)&&(tempAjax.status == 200)){
                tempResponseText = tempAjax.responseText;
                tempThis.funcProcess(tempResponseText.substr(1,tempResponseText.length-1));
                if(tempThis.isInFalse(tempResponseText[0])){
                    tempThis.funcFalse(tempResponseText.substr(1,tempResponseText.length-1));
                }else if(tempThis.isInTrue(tempResponseText[0])){
                    tempThis.funcTrue(tempResponseText.substr(1,tempResponseText.length-1));
                }else if(tempThis.isGoToDefaultPath(tempResponseText[0])){
                    window.location = window.location.origin+"/"+tempThis.targetPath;
                }else{
                    tempThis.funcAlternate(tempResponseText.substr(1,tempResponseText.length-1));
                }
                tempThis.tryReloadAsPosibble('postTrue');
            }else if((tempAjax.readyState == 4)&&(tempAjax.status == 0)){
                tempThis.postTrue();
            }else if(tempAjax.status > 400 && tempAjax != 404){
                tempThis.postTrue();
            }else{
                tempThis.showError('Page Not found');
            }
        };
        tempAjax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        tempAjax.send(this.content);
    };
    this.tryReloadAsPosibble = function(functionName){
        if(!this.reloadFunc) return false;
        tempThis = this;
        switch(functionName){
            case 'postTrue' : setTimeout(function () { tempThis.postTrue();},tempThis.timeOut); break;
            case 'postFalse' : setTimeout(function () { tempThis.postFalse();},tempThis.timeOut); break;
            case 'getTrue' : setTimeout(function () { tempThis.getTrue();},tempThis.timeOut); break;
            case 'getFalse' : setTimeout(function () { tempThis.getFalse();},tempThis.timeOut); break;
            default : tempThis.showError("function name cannot be recognized"); break;
        }
    };
    this.getTrue = function(){
        var tempAjax = this.getXmlHttpRequest();
        var tempThis = this;
        tempAjax.open('get', this.url,true);
        tempAjax.onreadystatechange = function(){
            if((tempAjax.readyState == 4)&&(tempAjax.status == 200)){
                tempResponseText = tempAjax.responseText;
                tempThis.funcProcess(tempResponseText.substr(1,tempResponseText.length-1));
                if(tempThis.isInFalse(tempResponseText[0])){
                    tempThis.funcFalse(tempResponseText.substr(1,tempResponseText.length-1));
                }else if(tempThis.isInTrue(tempResponseText[0])){
                    tempThis.funcTrue(tempResponseText.substr(1,tempResponseText.length-1));
                }else if(tempThis.isGoToDefaultPath(tempResponseText[0])){
                    window.location = window.location.origin+"/"+tempThis.targetPath;
                }else{
                    tempThis.funcAlternate(tempResponseText.substr(1,tempResponseText.length-1));
                }
                tempThis.tryReloadAsPosibble('getTrue');
            }else if((tempAjax.readyState == 4)&&(tempAjax.status == 0)){
                tempThis.postTrue();
            }else if(tempAjax.status > 400 && tempAjax != 404){
                tempThis.postTrue();
            }else{
                tempThis.showError('Page Not found');
            }
        };
        tempAjax.send();
    };
    this.getFalse = function(){
        var tempAjax = this.getXmlHttpRequest();
        var tempThis = this;
        tempAjax.open('get', this.url,false);
        tempAjax.onreadystatechange = function(){
            if((tempAjax.readyState == 4)&&(tempAjax.status == 200)){
                tempResponseText = tempAjax.responseText;
                tempThis.funcProcess(tempResponseText.substr(1,tempResponseText.length-1));
                if(tempThis.isInFalse(tempResponseText[0])){
                    tempThis.funcFalse(tempResponseText.substr(1,tempResponseText.length-1));
                }else if(tempThis.isInTrue(tempResponseText[0])){
                    tempThis.funcTrue(tempResponseText.substr(1,tempResponseText.length-1));
                }else if(tempThis.isGoToDefaultPath(tempResponseText[0])){
                    window.location = window.location.origin+"/"+tempThis.targetPath;
                }else{
                    tempThis.funcAlternate(tempResponseText.substr(1,tempResponseText.length-1));
                }
                tempThis.tryReloadAsPosibble('getFalse');
            }else if((tempAjax.readyState == 4)&&(tempAjax.status == 0)){
                tempThis.postTrue();
            }else if(tempAjax.status > 400 && tempAjax != 404){
                tempThis.postTrue();
            }else{
                tempThis.showError('Page Not found');
            }
        };
        tempAjax.send();
    };
    this.showError = function(message){
        if(this.alertFalseArgument){
            alert(message);
        }else{
            console.log(message);
        }
    };
    if(objectData){
        if(objectData.alertFalseArgument){
            if(typeof objectData.alertFalseArgument === 'bool'){
                this.alertFalseArgument = objectData.alertFalseArgument;
            }else{
                this.alertFalseArgument = settingJaservAjax.alertFalseArgument;
            }
        }else{
            this.alertFalseArgument = settingJaservAjax.alertFalseArgument;
        }
        if(objectData.targetPath){ this.targetPath = objectData.targetPath;}else{this.targetPath = settingJaservAjax.targetPath;}
        if(objectData.codeReloadToTargetPath){ this.codeReloadToTargetPath = objectData.codeReloadToTargetPath;}else{this.codeReloadToTargetPath = settingJaservAjax.codeReloadToTargetPath;}
        if(objectData.codeReloadFuncTrue){ this.codeReloadFuncTrue = objectData.codeReloadFuncTrue;}else{this.codeReloadFuncTrue = settingJaservAjax.codeReloadFuncTrue;}
        if(objectData.codeReloadFuncFalse){ this.codeReloadFuncFalse = objectData.codeReloadFuncFalse;}else{this.codeReloadFuncFalse = settingJaservAjax.codeReloadFuncFalse;}
        if(objectData.reloadFunc){ this.reloadFunc = objectData.reloadFunc;}else{this.reloadFunc = settingJaservAjax.reloadFunc;}
        if(objectData.url){this.url = window.location.origin+"/"+objectData.url;}else{this.url = window.location.origin+"/";}
        if(objectData.content){this.content = objectData.content;}else{this.content = '';}
        if(objectData.timeOut){this.timeOut = parseInt(objectData.timeOut);}else{this.timeOut = 2000;}
        if(typeof objectData.funcProcess === 'function'){
            this.funcProcess = function(message){
                try {
                    objectData.funcProcess(message);
                } catch (error) {
                    this.showError(error);
                }
            };
        }else{
            this.funcProcess = function(message){
                this.showError('true function not implemented');
            };
        }
        if(typeof objectData.funcTrue === 'function'){
            this.funcTrue = function(message){
                try {
                    objectData.funcTrue(message);
                } catch (error) {
                    this.showError(error);
                }
            };
        }else{
            this.funcTrue = function(message){
                this.showError('true function not implemented');
            };
        }
        if(typeof objectData.funcFalse === 'function'){
            this.funcFalse = function(message){
                try {
                    objectData.funcFalse(message);
                } catch (error) {
                    this.showError(error);
                }
            };
        }else{
            this.funcFalse = function(message){
                this.showError('false function not implemented');
            };
        } 
        if(typeof objectData.funcAlternate === 'function'){
            this.funcAlternate = function(message){
                try {
                    objectData.funcAlternate(message);
                } catch (error) {
                    this.showError(error);
                }
            };
        }else{
            this.funcAlternate = function(message){
                this.showError('alternate function not implemented');
            };
        }   
    }else{
        this.alertFalseArgument = settingJaservAjax.alertFalseArgument;
        this.codeReloadToTargetPath = settingJaservAjax.codeReloadToTargetPath;
        this.targetPath = settingJaservAjax.targetPath;
        this.codeReloadFuncFalse = settingJaservAjax.codeReloadFuncFalse;
        this.codeReloadFuncTrue == settingJaservAjax.codeReloadFuncTrue;
        this.timeOut = 2000;
        this.content = '';
        this.url = window.location.origin+"/";
        this.reloadFunc = settingJaservAjax.reloadFunc;
        this.funcTrue = function(message){
            this.showError('true function not implemented');
        };
        this.funcFalse = function(message){
            this.showError('false function not implemented');
        };
        this.funcAlternate = function(message){
            this.showError('alternate function not implemented');
        };
        this.funcProcess = function(message){
            this.showError('proses function not implemented');
        };
    }
};
/*
var e = new jaservAjax({
    url : 'test.php',
    targetPath : 'hollow.php',
    codeReloadToTargetPath : '&',
    codeReloadFuncTrue : '0/1',
    codeReloadFuncFalse : '2/3',
    reloadFunc : true,
    timeOut : 10000,
    funcTrue : function(message){
        alert("true "+message);
    },
    funcFalse : function(message){
        alert('false '+message);
    },
    funcAlternate : function(message){
        alert('alternate '+message);
    },
    funcProcess : function(message){
        alert('process '+message);
    }
});
e.postTrue();
*/