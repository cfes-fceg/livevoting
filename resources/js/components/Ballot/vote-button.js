import React, {useState} from "react";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCheckSquare } from '@fortawesome/free-solid-svg-icons';

export const BALLOT_OPTIONS = {
    FOR: 'FOR',
    AGAINST: 'AGAINST',
    ABSTAIN: 'ABSTAIN',
    UNSET: null
}

export function VoteButton({value, noted, onChange, rootClass, disabled}) {
    const [noteVote, setNoteVote] = useState(noted || false)
    const [ballotValue, setBallotValue] = useState(value || BALLOT_OPTIONS.UNSET)

    function onRadioChange(e) {
        if (!disabled) {
            setBallotValue(e.target.value);
            if (onChange) {
                onChange(e.target.value, noteVote);
            }
        }
    }

    function onNoteVoteChange(e) {
        if (!disabled) {
            setNoteVote(e.target.checked)
            if (onChange) {
                onChange(ballotValue, e.target.checked)
            }
        }
    }

    return (
        <div className={"btn-group btn-group-toggle " + rootClass}>
            <label className="btn btn-success ">
                <input
                    type="radio"
                    name="vote-options"
                    id={"option-"+BALLOT_OPTIONS.FOR}
                    autoComplete="off"
                    value={BALLOT_OPTIONS.FOR}
                    checked={ballotValue === BALLOT_OPTIONS.FOR}
                    onChange={onRadioChange}
                /> For {ballotValue === BALLOT_OPTIONS.FOR && <FontAwesomeIcon style={{'marginLeft': '0.3em'}} icon={faCheckSquare}/>}
            </label>
            <label className="btn btn-warning">
                <input
                    type="radio"
                    name="vote-options"
                    id={"option-"+BALLOT_OPTIONS.ABSTAIN}
                    autoComplete="off"
                    value={BALLOT_OPTIONS.ABSTAIN}
                    checked={ballotValue === BALLOT_OPTIONS.ABSTAIN}
                    onChange={onRadioChange}
                /> Abstain {ballotValue === BALLOT_OPTIONS.ABSTAIN && <FontAwesomeIcon style={{'marginLeft': '0.3em'}} icon={faCheckSquare}/>}
            </label>
            <label className="btn btn-danger">
                <input
                    type="radio"
                    name="vote-options"
                    id={"option-"+BALLOT_OPTIONS.AGAINST}
                    autoComplete="off"
                    value={BALLOT_OPTIONS.AGAINST}
                    checked={ballotValue === BALLOT_OPTIONS.AGAINST}
                    onChange={onRadioChange}
                />Against {ballotValue === BALLOT_OPTIONS.AGAINST && <FontAwesomeIcon style={{'marginLeft': '0.3em'}} icon={faCheckSquare}/>}
            </label>
            <label className="btn btn-secondary">
                <input
                    type="checkbox"
                    name="noted"
                    id="notes"
                    value={noteVote}
                    onChange={onNoteVoteChange}
                /> Note? {noteVote && <FontAwesomeIcon style={{'marginLeft': '0.3em'}} icon={faCheckSquare}/>}
            </label>
        </div>
    )
}
