import React, { Component } from 'react';
import {Switch, Route} from 'react-router-dom'; 
import {Teachers, Teacher, Home} from './Pages/'; 


class Main extends Component {
    render() {
        return (
            <div>
                <Switch>
                    <Route exact path="/" component={Home}/>
                    <Route exact path="/teachers" component={Teachers}/>
                    <Route exact truc="8" path="/teachers/:id" component={Teacher}/>
                </Switch>
            </div>
        );
    }
}

export {Main} ;