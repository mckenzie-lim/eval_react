import React, { Component } from 'react';
import {Link} from 'react-router-dom'; 

class Teachers extends Component {

    constructor(...props)
    {
        
        super(...props)
        this.state = 
        {
            is_data_loading:true
        }

        fetch("http://localhost/eval_react/public/rest/?table=teacher", 
        {
            mode:'cors', 
            headers: {
                "Content-Type":"application/json"
            }
        }).then(res=> {
            res.json().then( json=>
                {
                    this.list_teachers = json;
                    this.setState({is_data_loading:false});
                }
            );
        });
        
    }

    render() {
        if(this.state.is_data_loading) 
        {
            return (<p>Fetching data...</p>)    
        } else 
        {
            let list_tr = [];
            for (let i = 0; i < this.list_teachers.length; i++) 
            {
                const element = this.list_teachers[i];
                let row = (<tr key={"teacher_"+element.Id_teacher}>
                    <td>{element.Id_teacher}</td>
                    
                    <td>{element.firstname}</td>
                    
                    <td>{element.lastname}</td>
                    
                    <td><Link to={"teachers/" + element.Id_teacher}>Détail</Link></td>
                </tr>);
                list_tr.push(row);
            }
            return (
                <div>
                <p>Hello Teachers</p>

                <br />
                <div style={{padding:"50px"}}>
                    <table border="1">
                    <thead>
                        <tr>
                            <th >Id</th>
                            <th >Last Name</th>
                            <th >First Name</th>
                            <th >Details</th>
                        </tr>
                    </thead>
                    <tbody>
                       {list_tr}
                    </tbody>
                </table>
                </div>
                
            </div>
            )

        }
    }
}

export { Teachers };