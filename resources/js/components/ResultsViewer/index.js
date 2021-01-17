import React, {useEffect, useRef, useState} from 'react';
import ReactDOM from 'react-dom';
import axios from "axios";
import {ResultGraph} from "../ResultGraph";
import {VoteButton} from "../Ballot/vote-button";

function useInterval(callback, delay) {
    const savedCallback = useRef();

    // Remember the latest callback.
    useEffect(() => {
        savedCallback.current = callback;
    }, [callback]);

    // Set up the interval.
    useEffect(() => {
        function tick() {
            savedCallback.current();
        }

        if (delay !== null) {
            let id = setInterval(tick, delay);
            return () => clearInterval(id);
        }
    }, [delay]);
}

function ResultsViewer({dataString, className}) {
    const [question, setQuestion] = useState(null);
    const [notedVotes, setNotedVotes] = useState([]);
    const [error, setError] = useState("");
    const [data, setData] = useState(null);
    const [isLoading, setIsLoading] = useState(true);
    const [isInitialized, setIsInitialized] = useState(false);
    const [autoRefresh, setAutoRefresh] = useState(question && question['is_active'] !== 0);
    const [refreshInterval, setRefreshInterval] = useState(0);
    const [counter, setCounter] = useState(5);

    useEffect(() => {
        updateResults();
    }, [question])

    useInterval(() => {
        if (autoRefresh && !isLoading) {
            // Your custom logic here
            if (counter > 0)
                setCounter(counter - 1);
            if (counter === 0) {
                setIsLoading(true);
                updateResults();
            }
        }
    }, 1000);

    useEffect(() => {
        let parsedData = JSON.parse(dataString)
        if (parsedData && parsedData.question) {
            console.log(parsedData);
            setQuestion(parsedData.question);
        } else {
            setQuestion({});
            setError("No question provided")
        }
    }, [dataString])

    useEffect(() => {
        setIsInitialized(true);
    }, [data])

    function updateResults() {
        if (question) {
            setIsLoading(true);
            axios.get('/api/questions/' + question.id + '/results').then((response) => {
                if (response.status === 200) {
                    setData(response.data);
                } else {
                    console.debug(response);
                    setError(response.data.error);
                }
            }).catch(error => {
                setError(error.toString())
            }).then(() => {
                axios.get('/api/questions/' + question.id + '/noted').then((response) => {
                    if (response.status === 200) {
                        setNotedVotes(response.data);
                    } else {
                        console.debug(response);
                        setError(response.data.error);
                    }
                }).catch(error => {
                    setError(error.toString())
                }).then(() => {
                    setIsLoading(false);
                    setCounter(5);
                });
            });
        }
    }

    function onAutoRefreshToggle(e) {
        if (e.target.checked)
            setCounter(5);
        setAutoRefresh(e.target.checked);
    }

    return (
        <div className={"col-12 p-0"}>
            {!isInitialized &&
            <div className="position-absolute h-100 w-100 d-flex justify-content-center align-items-center"
                 style={{'zIndex': 50, 'backgroundColor': 'rgba(25,25,25,0.4)'}}>
                <div className="spinner-border text-light" role="status">
                    <span className="sr-only">Loading...</span>
                </div>
            </div>
            }
            <div className={"card-body row"}>
                {error &&
                <div className="alert alert-danger w-100 h-100">
                    {error}
                </div>
                }

                <div className={"col-md-6 mx-auto row"}>
                    <div className={"mx-auto"}>
                        <ResultGraph height={400} width={400} data={data}/>
                    </div>
                </div>
                <div className="col-md-6 px-3 d-flex align-items-stretch flex-column">
                    <div className="flex-fill">
                        <div className="d-flex h-100">
                            <ul className="list-group list-group-horizontal align-self-center w-100">
                                <li className="list-group-item list-group-item-success col-4 text-center">
                                    <h4 className={"mb-0"}>
                                        For<br/>
                                        <span className="badge badge-success badge-pill">{data ? data.FOR : 0}</span>
                                    </h4>
                                </li>
                                <li className="list-group-item list-group-item-danger col-4 text-center">
                                    <h4 className={"mb-0"}>
                                        Against<br/>
                                        <span className="badge badge-danger badge-pill">{data ? data.AGAINST : 0}</span>
                                    </h4>
                                </li>
                                <li className="list-group-item list-group-item-warning col-4 text-center">
                                    <h4 className={"mb-0"}>
                                        Abstain<br/>
                                        <span
                                            className="badge badge-warning badge-pill">{data ? data.ABSTAIN : 0}</span>
                                    </h4>
                                </li>
                            </ul>
                        </div>
                    </div>
                    {isInitialized && notedVotes.length > 0 &&
                    <div className={"my-4"}>
                        <h5>Noted Votes:</h5>
                        <div className="row">
                            {notedVotes.map((notedVote, index) => {
                                return <div key={index} className="col-6">
                                    {notedVote.eng_soc.name} <span
                                    className={"badge badge-secondary"}>{notedVote.vote}</span>
                                </div>
                            })}
                        </div>
                    </div>
                    }
                    <div>
                        {(isInitialized && question['is_active'] !== 0) &&
                        <div className="float-right">
                            <div className="form-inline">
                                {autoRefresh &&
                                <div className="input-label mr-2">Auto-refresh in {counter} seconds...</div>
                                }
                                <div className="input-group">
                                    <button disabled={autoRefresh}
                                            className={"form-control " + (autoRefresh ? 'disabled' : 'btn-primary')}
                                            onClick={updateResults}>Refresh
                                    </button>
                                    <div className="input-group-append">
                                        <label className="input-group-text">
                                            Auto&nbsp;&nbsp;
                                            <input type="checkbox" onChange={onAutoRefreshToggle}
                                                   checked={autoRefresh}
                                                   aria-label="Checkbox for following text input"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        }
                    </div>
                </div>
            </div>
        </div>
    )
}

if (document.getElementById('results-viewer')) {
    let domObj = document.getElementById('results-viewer');
    let data = domObj.getAttribute('data');
    domObj.setAttribute('data', null)
    let classes = domObj.getAttribute('class');
    ReactDOM.render(<ResultsViewer dataString={data} className={classes}/>, domObj);
}
