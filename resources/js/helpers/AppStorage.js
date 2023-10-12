class AppStorage{

    storeToken(token){  
            //--To store the 'token' in browser's "Application > Local Storage"
            sessionStorage.setItem('token',token);
    }

    storeUser(user){       //----To store user's all info-----
        sessionStorage.setItem('user',user);
    }

    storeType(type){       //----To store type's all info-----
        sessionStorage.setItem('type',type);
    }

    store(token, user, type){ 
        this.storeToken(token)
        this.storeUser(user)
        this.storeType(type)
    }

    clear(){              //-------for logout-----
        sessionStorage.removeItem('token')
        sessionStorage.removeItem('user')
        sessionStorage.removeItem('type')
    }

    getToken(){
        sessionStorage.getItem('token');
    }

    getUser(){
        sessionStorage.getItem('user');
    }

    getType(){
        sessionStorage.getItem('type');
    }

}

export default AppStorage = new AppStorage();
