import React, {useState} from 'react';
import {BALLOT_OPTIONS, VoteButton} from './vote-button';
import axios from 'axios';
import {FontAwesomeIcon} from '@fortawesome/react-fontawesome';
import {faVoteYea} from '@fortawesome/free-solid-svg-icons';

function Ballot({className, engSocs, question, onCompletion}) {
    const [error, setError] = useState("");
    const [votes, setVotes] = useState({});
    const [isLoading, setIsLoading] = useState(false);
    const [isComplete, setIsComplete] = useState(false);

    const [votingEnabled, setVotingEnabled] = useState(true);

    function onVoteChange(id) {
        return function (value) {
            let vts = {...votes}
            vts[id] = value;
            setVotes(vts);
        }
    }

    function onBallotCast() {
        setIsLoading(true);
        if (validateForm()) {
            setError("");
            axios.post('/api/questions/'+question.id+'/votes', {
                votes: votes,
            }).then(request => {
                console.log(request);
                if (request.status === 201) {
                    setIsComplete(true);
                    if (onCompletion) {
                        onCompletion(this);
                    }
                } else {
                    setError(request.data.toString());
                }
            }).catch(error => {
                setError(error.toString())
                console.log(error);
            }).then(() => {
                setIsLoading(false);
            })
        } else {
            setIsLoading(false);
        }
    }

    function validateForm() {
        for (let index in engSocs) {
            if (!votes[engSocs[index].id]) {
                setError("EngSoc " + engSocs[index].name + " has not selected an option.");
                return false;
            }
        }
        return true;
    }

    return (
        <div className={className}>
            <div className="card">
                {isLoading &&
                <div className="w-100 h-100 position-absolute d-flex justify-content-center align-items-center"
                     style={{'zIndex': 50, 'backgroundColor': 'rgba(25,25,25,0.4)'}}>
                    <div className="spinner-border text-light" role="status">
                        <span className="sr-only">Loading...</span>
                    </div>
                </div>
                }
                {isComplete &&
                <div className="w-100 h-100 position-absolute d-flex justify-content-center align-items-center"
                     style={{'zIndex': 50, 'backgroundColor': 'rgba(56,193,114,0.4)'}}>
                    <div>
                        <FontAwesomeIcon size="8x" icon={faVoteYea} style={{'color': 'white'}}/>
                    </div>
                </div>
                }
                {engSocs && engSocs.length && question &&
                <>
                    <div className="card-header">Vote #{question.id}: {question.title}</div>

                    <ul className="list-group list-group-flush">
                        {engSocs.map((engSoc, index) => {
                            return <li key={index} className="list-group-item">
                                <div className="row">
                                    <div className="col-5">
                                        {engSoc.name}
                                    </div>
                                    <div className="col-7">
                                        <VoteButton value={votes[engSoc.id]}
                                                    disabled={!votingEnabled}
                                                    rootClass={"float-right"}
                                                    onChange={onVoteChange(engSoc.id)}
                                        />
                                    </div>
                                </div>
                            </li>
                        })}

                    </ul>
                </>
                }

                <div className="card-body">
                    <div className="row">
                        <div className="col-8">
                            {error &&
                            <div className="alert alert-danger mb-0">
                                <span className="font-weight-bold">Error: </span>{error}
                            </div>
                            }
                        </div>
                        <div className="col-4">
                            {votingEnabled &&
                            <button className={"alert btn float-right btn-primary mb-0"} onClick={onBallotCast}>
                                {engSocs.length > 1 ? 'Cast votes' : 'Cast vote'}
                            </button>
                            }
                        </div>
                    </div>
                </div>

            </div>

        </div>
    );
}

export {Ballot, BALLOT_OPTIONS}
