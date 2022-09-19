export default class Gate {

    constructor(user) {
        this.user=user
    }

    isAdmin(){
        return this.user.role==='admin'//||this.user.role==='user'
    }

    isUser(){
        return this.user.role==='user'
    }

    isAdminOrAuther(){
        return this.user.role==='admin'||this.user.role==='user'
    }

    getAuthUserId(){
        return this.user.salon_id
    }
}
