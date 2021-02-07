import React, { Component } from 'react';

class Teacher extends Component {
    constructor(...props) {

        super(...props);
        this.Id_teacher = this.props.match.params.id;
        this.state =
        {
            is_data_loading: true
        }

        fetch("http://localhost/eval_react/public/rest/?table=teacher",
            {
                mode: 'cors',
                headers: {
                    "Content-Type": "application/json"
                }
            }).then(res => {
                res.json().then(json => {
                    this.list_teachers = json;
                    this.teacher = this.list_teachers.filter(elt => elt["Id_teacher"] == this.Id_teacher);
                    console.log(this.teacher); 
                    this.setState({ is_data_loading: false });
                }
                );
            });
    }
    render() {
        if (this.state.is_data_loading) {
            return (<p>Fetching data...</p>)
        } else {
            return (
                <div>
                    <h1>Hello Teacher {this.teacher[0].firstname + " " + this.teacher[0].lastname} </h1>
                </div>
            );
        }



    }
}

export { Teacher };