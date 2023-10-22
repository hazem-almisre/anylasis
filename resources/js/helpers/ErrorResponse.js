

class ErrorResponse{

    ErrorResponse(status,data){
        if(status == 400){

        }  
        else if(status == 422){

        }
        else{
            Notification.error();
        }
    }
}

export default Notification = new Notification()