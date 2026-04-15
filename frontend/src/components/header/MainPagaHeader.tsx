import TagHeader from './TagHeader'
import AppName from './AppName'
import ExpenditureHeader  from './ExpenditureHeader'

export default function AllPageHeader() {
    return (
        <div className="flex items-center w-full">
            <div className="flex gap-4 flex-wrap">
                <ExpenditureHeader
                    headerMessage = '確定支出追加・削除'
                    to = "/login"
                    apiEndpoint='must-expenditures'
                />
                <ExpenditureHeader
                    headerMessage = '支出追加・削除'
                    to = "/login"
                    apiEndpoint='daily-expenditures'
                />
                <TagHeader
                    headerMessage = 'タグ追加・削除'
                    to = "/login"
                    apiEndpoint='/api/daily-expenditure-tags'
                />
                <TagHeader
                    headerMessage = '必須出資タグ追加・削除'
                    to = "/login"
                    apiEndpoint='must-expenditure-tags'
                />
            </div>
            <div className="ml-auto shrink-0 pl-4">
                <AppName/>
            </div>
        </div>
    )
}