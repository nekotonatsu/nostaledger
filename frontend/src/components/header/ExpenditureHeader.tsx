import { useState } from 'react'
import AddExpenditureForm from '../contents/form/addExpenditureForm'

interface Props {
    headerMessage: string
    apiEndpoint: string
    isOpen: boolean
    setIsOpen: (isOpen: boolean) => void
}

export default function ExpenditureHeader({ 
    headerMessage,
    apiEndpoint,
    isOpen,
    setIsOpen
}: Props) {
    return (
        <div className="relative">
            <button
                onClick={() => setIsOpen(!isOpen)}
                className="flex items-center gap-1 text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors"
            >
                {headerMessage}
                <span className="text-xs">{isOpen ? '▲' : '▼'}</span>
            </button>

            {isOpen && (
                <div className="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-100 p-4 z-50">
                    <AddExpenditureForm
                        apiEndpoint={apiEndpoint}
                        onCancel={() => setIsOpen(false)}
                    />
                </div>
            )}
        </div>
    )
}
