import React, {useEffect, useState} from 'react';
import ReactDOM from 'react-dom';
import {Ballot, BALLOT_OPTIONS} from "../Ballot";
import axios from 'axios';

function VotingBooth({dataString, className}) {
    const [engSocs, setEngSocs] = useState([]);
    const [activeQuestions, setActiveQuestions] = useState([]);
    const [error, setError] = useState("");

    useEffect(() => {
        let parsedData = JSON.parse(dataString)
        if (parsedData.engSocs && parsedData.engSocs.length) {
            parsedData.engSocs = parsedData.engSocs.map(engSoc => {
                engSoc.vote = BALLOT_OPTIONS.UNSET;
                return engSoc;
            });
            setEngSocs(parsedData.engSocs)
        } else {
            setEngSocs([]);
        }

        fetchAndUpdateActiveQuestions();
    }, [dataString])

    function fetchAndUpdateActiveQuestions() {
        axios.get('/api/questions/active').then((response) => {
            if (response.status === 200) {
                setActiveQuestions(response.data);
            } else {
                console.debug(response);
                // setError(response.data.error)
            }
        }).catch(error => {
            setError(error.toString())
        });
    }

    return (
        <div className="card">
            <div className="card-header">
                <div className="row">
                    <div className="col-10">
                        {error &&
                        <div className="alert alert-danger mb-0">
                            <span className="font-weight-bold">Error: </span>
                            {error}
                        </div>
                        }
                    </div>
                    <div className="col-2">
                        <button className="alert btn btn-primary float-right mb-0"
                                onClick={fetchAndUpdateActiveQuestions}>Refresh
                        </button>
                    </div>
                </div>
            </div>
            {activeQuestions.length === 0 &&
            <div className="jumbotron w-100 h-100 mb-0">
                <h1 className="display-4">Hello, user!</h1>
                <p className="lead">There are currently no active questions. Click refresh to check again</p>
                <hr className="my-4"/>
            </div>
            }
            {activeQuestions.length > 0 &&
            <div className="row pt-4 pl-4 pr-4">
                {activeQuestions.map((question, index) => {
                    return (
                        <Ballot className="col-12 col-md-6 mx-auto pb-4" key={index} engSocs={engSocs}
                                question={question}/>
                    )
                })}
            </div>
            }
        </div>
    )
}

if (document.getElementById('voting-booth')) {
    let domObj = document.getElementById('voting-booth');
    let data = domObj.getAttribute('data');
    domObj.setAttribute('data', null)
    let classes = domObj.getAttribute('class');
    ReactDOM.render(<VotingBooth dataString={data} className={classes}/>, document.getElementById('voting-booth'));
}
